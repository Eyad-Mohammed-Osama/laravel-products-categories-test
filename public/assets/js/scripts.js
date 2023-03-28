function showNotification(title, text, type, autohide = 5000, url = null) {
    $(window).off("beforeunload");
    toastr[type](
        text,
        title, {
        closeButton: true,
        tapToDismiss: true,
        showDuration: 500,
        hideDuration: 500,
        timeOut: autohide === false ? null : autohide,
        extendedTimeOut: autohide === false ? null : autohide,
        progressBar: autohide !== false,
        showEasing: "linear",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
        onHidden: () => {
            if (type === "success") {
                $(".modal").modal("hide");
                if (url) {
                    window.location.href = url;
                } else {
                    window.location.reload();
                }
            }
        }
    }
    );
}

function showErrorNotification(xhr) {
    if (xhr.status === 422) {
        let str = ``;
        const errors = xhr.responseJSON.errors;
        for (let j = 0; j < errors.length; j++) {
            str += `<li>${errors[j]}</li>`;
        }
        showNotification("Validation Errors", "It seems there are some validation errors<br> " + str, "error", false);
    } else if (xhr.status === 500) {
        showNotification("Internal Server Error", "Operation has failed due to internal server error. Please try again later.", "error", false);
    }
}

function showSuccessNotification(text) {
    showNotification("Operation completed successfully", text, "success", 1000);
}

function showInfoNotification(text = null) {
    if (text === null) {
        text = "Please wait while we process the request. When process is finished a new popup will appear on the screen.";
    }
    showNotification("Waiting for response", text, "info", 3000);
}

function renderValidationErrors(object) {
    $("input, textarea").not("[type='hidden']").removeClass("is-invalid");
    $("div.invalid-feedback").html(null);
    const errors = object.errors;
    const fields = Object.keys(errors);

    for (let i = 0; i < fields.length; i++) {
        const field = $(`[name='${fields[i]}']`);
        field.addClass("is-invalid");
        let errorFeedback = field.next("div.invalid-feedback");

        const key = fields[i];
        let str = "";
        const fieldErrors = errors[key];

        for (let j = 0; j < fieldErrors.length; j++) {
            str += `<li>${fieldErrors[j]}</li>`;
        }

        errorFeedback.html(`<ul>${str}</ul>`);
    }
}

function viewSaveSuccessAlert(url = null) {
    Swal.fire({
        title: "تم التخزين بنجاح",
        text: "تم تخزين المعلومات المدخلة بنجاح",
        confirmButtonText: 'حسناً',
        icon: "success"
    }).then((result) => {
        if (url !== null) {
            window.location.href = url;
        }
    });
}

function viewSaveErrorAlert(code = 422) {
    let text = "فشلت عملية تخزين المعلومات و ذلك ";
    switch (code) {
        case 403:
            text += "بسبب عدم وجود صلاحيات كافية للقيام بالعملية المطلوبة.";
            break;

        case 404:
            text += "ﻷن الكيان المطلوب غير موجود في النظام.";
            break;

        case 422:
            text += "بسبب أخطاء في الإدخال. يرجى مراجعة الحقول و المحاولة مجدداً.";
            break;

        case 500:
            text += "بسبب خطأ داخلي في المخدم. يرجى المحاولة مجدداً لاحقاً. ";
            break;
    }

    Swal.fire({
        title: "فشلت عملية التخزين",
        text: text,
        confirmButtonText: 'حسناً',
        icon: "error"
    });
};

function viewDeleteAlert(url, table, data = {}) {
    Swal.fire({
        title: 'تأكيد حذف العنصر المحدد',
        text: "هل أنت من رغبتك بحذف العنصر المحدد ؟. لاحظ أنه لا يمكنك التراجع عن هذه العملية.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'نعم',
        cancelButtonText: 'لا',
        customClass: {
            cancelButton: "btn btn-danger",
            confirmButton: "btn btn-primary"
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const token = $("meta[name='csrf-token']").attr("content");
            data["_token"] = token;
            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function (response) {
                    $(table).DataTable().ajax.reload();
                }
            });
        }
    })
}