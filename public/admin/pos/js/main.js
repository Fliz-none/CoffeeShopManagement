function slideToggle(t, e, o) {
    0 === t.clientHeight ? j(t, e, o, !0) : j(t, e, o);
}
function slideUp(t, e, o) {
    j(t, e, o);
}
function slideDown(t, e, o) {
    j(t, e, o, !0);
}
function j(t, e, o, i) {
    void 0 === e && (e = 400),
        void 0 === i && (i = !1),
        (t.style.overflow = "hidden"),
        i && (t.style.display = "block");
    var p,
        l = window.getComputedStyle(t),
        n = parseFloat(l.getPropertyValue("height")),
        a = parseFloat(l.getPropertyValue("padding-top")),
        s = parseFloat(l.getPropertyValue("padding-bottom")),
        r = parseFloat(l.getPropertyValue("margin-top")),
        d = parseFloat(l.getPropertyValue("margin-bottom")),
        g = n / e,
        y = a / e,
        m = s / e,
        u = r / e,
        h = d / e;
    window.requestAnimationFrame(function l(x) {
        void 0 === p && (p = x);
        var f = x - p;
        i
            ? ((t.style.height = g * f + "px"),
              (t.style.paddingTop = y * f + "px"),
              (t.style.paddingBottom = m * f + "px"),
              (t.style.marginTop = u * f + "px"),
              (t.style.marginBottom = h * f + "px"))
            : ((t.style.height = n - g * f + "px"),
              (t.style.paddingTop = a - y * f + "px"),
              (t.style.paddingBottom = s - m * f + "px"),
              (t.style.marginTop = r - u * f + "px"),
              (t.style.marginBottom = d - h * f + "px")),
            f >= e
                ? ((t.style.height = ""),
                  (t.style.paddingTop = ""),
                  (t.style.paddingBottom = ""),
                  (t.style.marginTop = ""),
                  (t.style.marginBottom = ""),
                  (t.style.overflow = ""),
                  i || (t.style.display = "none"),
                  "function" == typeof o && o())
                : window.requestAnimationFrame(l);
    });
}

let sidebarItems = document.querySelectorAll(".sidebar-item.has-sub");
for (var i = 0; i < sidebarItems.length; i++) {
    let sidebarItem = sidebarItems[i];
    sidebarItems[i]
        .querySelector(".sidebar-link")
        .addEventListener("click", function (e) {
            e.preventDefault();

            let submenu = sidebarItem.querySelector(".submenu");
            if (submenu.classList.contains("active"))
                submenu.style.display = "block";

            if (submenu.style.display == "none")
                submenu.classList.add("active");
            else submenu.classList.remove("active");
            slideToggle(submenu, 300);
        });
}

window.addEventListener("DOMContentLoaded", (event) => {
    var w = window.innerWidth;
    if (w < 1200) {
        document.getElementById("sidebar").classList.remove("active");
    }
});
// window.addEventListener('resize', (event) => {
//     var w = window.innerWidth;
//     if (w < 1200) {
//         document.getElementById('sidebar').classList.remove('active');
//     } else {
//         document.getElementById('sidebar').classList.add('active');
//     }
// });

document.querySelector(".burger-btn").addEventListener("click", () => {
    document.getElementById("sidebar").classList.toggle("active");
});
document.querySelector(".sidebar-hide").addEventListener("click", () => {
    document.getElementById("sidebar").classList.toggle("active");
});

// Perfect Scrollbar Init
if (typeof PerfectScrollbar == "function") {
    const container = document.querySelector(".sidebar-wrapper");
    const ps = new PerfectScrollbar(container, {
        wheelPropagation: false,
    });
}

$(".submenu-item.active")
    .parents(".submenu")
    .addClass("d-block active")
    .parents(".has-sub")
    .addClass("active");

// $('.submenu-item > a').each(function () {
//     // kiểm tra từng thẻ a trong thẻ có class submenu-item
//     if ($(this).attr('href') === window.location.href) {
//         $(this).parent().addClass('active').parents('.submenu').addClass('active').parents('.sidebar-item').addClass('active')
//     }
// })

// $('.sidebar-link').each(function () {
//     // kiểm tra từng thẻ có class sidebar-link
//     if ($(this).attr('href') === window.location.href) {
//         $(this).parent().addClass('active')
//     }
// })

// // Scroll into active sidebar
// document.querySelector('.sidebar-item.active').scrollIntoView(false)

/**
 * Định dạng số 0,000,000
 */
function number_format(nStr) {
    nStr += "";
    x = nStr.split(".");
    x1 = x[0];
    x2 = x.length > 1 ? "." + x[1] : "";
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, "$1" + "," + "$2");
    }
    return x1 + x2;
}

//Input mask money
$(".money").focus(function () {
    $(".money").mask("# ##0", {
        reverse: true,
    });
});
$(".money").blur(function () {
    $(".money").unmask();
});

/**
 * Reset form
 */
function resetForm(frm) {
    frm.trigger("reset")
        .find(".modal")
        .modal("hide")
        .find(".is-invalid")
        .removeClass("is-invalid")
        .next()
        .remove("span");
    frm.find("[type=hidden]").val("");
}

/**
 * Submit form
 */
function submitForm(frm) {
    const btn = frm.find("button[type=submit]");
    btn.prop("disabled", true).html(
        '<span class="spinner-border spinner-border-sm text-light" role="status"></span>'
    );
    return $.ajax({
        data: new FormData(frm[0]),
        url: frm.attr("action"),
        method: frm.attr("method"),
        contentType: false,
        processData: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name = "csrf-token"]').attr("content"),
        },
        success: function (response) {
            btn.prop("disabled", false).html("Lưu");
            frm.find(".modal").modal("hide");
            if (frm.attr("id") === "transaction-form") {
                bill_order = frm.find("#transaction-order_id").val();
                bill_amount = frm.find("#transaction-receive").val();
            }
            if(frm.hasClass('form-remove-table')){
                window.location.reload();
            }
            $(".dataTable").each(function () {
                $(this).DataTable().clear().draw();
            });
            Toastify({
                text: response.title,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "center",
                backgroundColor: `var(--bs-${response.status})`,
            }).showToast();
            $(".btn-removes").addClass("d-none");
            $(".process-btns").addClass("d-none");
            resetForm(frm);
            if (
                response.title == "Đã cài đặt chấm công!" ||
                response.title == "Đã cập nhật logo thành công!"
            ) {
                setTimeout(function () {
                    location.reload();
                }, 100);
            }
        },
        error: function (errors) {
            btn.prop("disabled", false).html("Thử lại");
            frm.find(".is-invalid")
                .removeClass("is-invalid")
                .next()
                .remove("span");
            $.each(errors.responseJSON.errors, function (key, error) {
                const el = frm.find('[name="' + key + '"]');
                if (el.length) {
                    el.addClass("is-invalid").next().remove("span");
                    el.after(
                        $('<span class="text-danger">' + error[0] + "</span>")
                    );
                } else {
                    Toastify({
                        text: error[0],
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "var(--bs-danger)",
                    }).showToast();
                }
            });
        },
    });
}

// Xử lý khi người dùng click vào hình ảnh bất kỳ
$(document).on("click", "img.thumb", function () {
    Swal.fire({
        imageUrl: $(this).attr("src"),
        padding: 0,
        showConfirmButton: false,
        background: "transparent",
    });
});

/**
 * Check choice
 */
$(document).on("change", ".all-choices", function (e) {
    $(".choice").each(function () {
        $(this).prop("checked", $(".all-choices").prop("checked")).change();
    });
});
$(document).on("change", ".choice", function (e) {
    e.preventDefault();
    if ($(".choice:checked").length) {
        $(".btn-removes").removeClass("d-none");
    } else {
        $(".btn-removes").addClass("d-none");
    }
});

/**
 * Remove multiple
 */
$(document).on("click", ".btn-removes", function (e) {
    e.preventDefault();
    let btn = $(this);
        btn.prop("disabled", true)
        .html('<span class="spinner-border spinner-border-sm text-light" role="status"></span>');
    const form = $("#batch-form");
    form.attr("action", config.routes.batchRemove);
    submitForm(form).done(
        function () {
            btn.prop("disabled", false).html('<i class="bi bi-trash"></i> Xóa')
        }
    );
});

/**
 * Remove a element
 */
$(document).on("click", ".btn-remove", function (e) {
    e.preventDefault();
    const form = $(this).parent();
    submitForm(form);
});

$(document).on("mouseenter", '[data-bs-toggle="tooltip"]', function () {
    $(this).tooltip("show");
});

$(document).on("mouseleave", '[data-bs-toggle="tooltip"]', function () {
    $("[data-toggle='tooltip']").tooltip("destroy");
    $(".tooltip").remove();
});

/**
 * Profile
 */
$(document).on("click", ".btn-profile-password", function () {
    const id = $(this).attr("data-id");
    $("#profile-password-form").attr(
        "action",
        `{{ route('profile.change-password') }}`
    );
    $.get(`{{ url('user/get/') }}/${id}`, function (user) {
        const form = $("#profile-password-form");
        resetForm(form);
        form.find(`[name='id']`).val(user.id);
        form.find(".modal").modal("show");
    });
});

/**
 * reload form
 */
function loadForm() {
    var form = $("#profile-modal");
    form.find("#profile-name").attr("readonly", true);
    form.find("#profile-phone").attr("readonly", true);
    form.find("#profile-mail").attr("readonly", true);

    form.find(".btn-update-profile").removeClass("d-none");
    form.find(".btn-save-profile").addClass("d-none");

    $("#profile-form")
        .trigger("reset")
        .find(".is-invalid")
        .removeClass("is-invalid")
        .next()
        .remove("span");
}

$(document).on("click", ".btn-profile", function (e) {
    e.preventDefault();
    loadForm();
    $("#profile-modal").modal("show");
});

$(document).on("click", "#close", function (e) {
    location.reload();
});

$(document).on("click", ".btn-update-profile", function (e) {
    e.preventDefault();
    const form = $("#profile-form");
    form.find("#profile-name").removeAttr("readonly").attr("required", "");
    form.find("#profile-phone").removeAttr("readonly").attr("required", "");
    form.find("#profile-mail").removeAttr("readonly").attr("required", "");

    form.find(".btn-update-profile").addClass("d-none");
    form.find(".btn-save-profile").removeClass("d-none");

    form.attr("action", `{{ route('user.update') }}`);
});

$(document).on("click", ".btn-save-profile", function (e) {
    e.preventDefault();
    const form = $("#profile-form");
    $.ajax({
        data: form.serializeArray(),
        url: form.attr("action"),
        method: form.attr("method"),
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            Toastify({
                text: response.title,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "center",
                backgroundColor: "#4fbe87",
            }).showToast();
            form.trigger("reset");
            const id = $("#profile-id").val();
            $.get(`{{ url('user/get') }}/${id}`, function (user) {
                form.find(`[name='name']`).val(user.name);
                form.find(`[name='email']`).val(user.email);
                form.find(`[name='phone']`).val(user.phone);
            });
            loadForm();
            form.find(".modal").modal("show");
        },
        error: function (errors) {
            form.find(".is-invalid")
                .removeClass("is-invalid")
                .next()
                .remove("span");
            $.each(errors.responseJSON.errors, function (key, error) {
                const el = form.find('[name="' + key + '"]');
                el.addClass("is-invalid").next().empty();
                el.after(
                    $('<span class="text-danger">' + error[0] + "</span>")
                );
            });
        },
    });
});

$(".btn-upload-images").click(function () {
    $("#quick_images-dropzone").trigger("click");
});

//Bật modal sửa thông tin ảnh
$(document).on("click", ".btn-edit-image", function () {
    const id = $(this).attr("data-id"),
        form = $("#quick_images-edit-form");
    $.get(`${general.routes.image.get}/` + id, function (image) {
        form.find("[name=name]").val(image.name.split(".")[0]);
        form.find("[name=alt]").val(image.alt);
        form.find("[name=caption]").val(image.caption);
        form.find("[name=id]").val(image.id);
        form.find(".card-img").attr("src", image.thumb);
        form.find(".btn-delete-image").attr("data-id", image.id);
        form.find(".modal").modal("show");
    });
});

//Sửa thông tin ảnh
$("#quick_images-edit-form").submit(function (e) {
    e.preventDefault();
    submitForm($(this));
});

//Xoá ảnh đơn lẻ
$(document).on("click", ".btn-delete-image", function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Xác nhận?",
        text: "Vui lòng xác nhận trước khi tiếp tục!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--bs-danger)",
        cancelButtonColor: "var(--bs-primary)",
        confirmButtonText: "OK, xoá đi!",
    }).then((result) => {
        if (result.isConfirmed) {
            submitForm($(this).parents("form"));
        }
    });
});

$(document).on("change", ".quick_images-choice", function (e) {
    if ($("#grid-view").find(".quick_images-choice:checked").length) {
        $(".process-btns").removeClass("d-none");
    } else {
        $(".process-btns").addClass("d-none");
    }
});

//Xoá hàng loạt ảnh
$(".btn-delete-images").click(function () {
    $("#quick_images-form").attr("action", general.routes.image.batch.delete);
    Swal.fire({
        title: "Xác nhận?",
        text: "Vui lòng xác nhận trước khi tiếp tục!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--bs-danger)",
        cancelButtonColor: "var(--bs-primary)",
        confirmButtonText: "OK, xoá đi!",
    }).then((result) => {
        if (result.isConfirmed) {
            submitForm($("#quick_images-form"));
            $(".process-btns").addClass("d-none");
        }
    });
});

//Chọn hình ảnh
$(document).on("click", ".btn-select-images", function () {
    let imagesName = [];
    if ($(this).attr("data-select") == "single") {
        imagesName.length = 0;
    } else {
        imagesName = $("#" + $(this).attr("data-target"))
            .val()
            .split("|");
    }
    $(".quick_images-choice:checked").each(function () {
        imagesName.push($(this).attr("data-name"));
    });
    $("#" + $(this).attr("data-target"))
        .val(imagesName.join("|"))
        .change();
    $(this)
        .addClass("d-none")
        .parents(".modal")
        .modal("hide")
        .find(".quick_images-choice")
        .attr("type", "checkbox")
        .prop("checked", false); //reset
});

//Xử lý hiển thị hình ảnh cho module gallery_images
function viewImage(input) {
    if (input.val() != "") {
        $(`label[for='${input.attr("id")}']`)
            .find("img")
            .attr("src", general.routes.storageDir + "/" + input.val());
        input.parents(".card").find(".btn-remove-image").removeClass("d-none");
    } else {
        $(`label[for='${input.attr("id")}']`)
            .find("img")
            .attr("src", general.routes.placeholder);
        input.parents(".card").find(".btn-remove-image").addClass("d-none");
    }
}

function openQuickImages(target, isSingle = true) {
    $("#quick_images-modal").modal("show");
    $(".quick_images-choice").attr("type", isSingle ? "radio" : "checkbox");
    $(".btn-select-images")
        .removeClass("d-none")
        .attr("data-target", target)
        .attr("data-select", isSingle ? "single" : "multiple");
    $(".btn-insert-images").addClass("d-none");
}
//END xử lý hình ảnh đưa vào content

/**
 * Xử lý hiển thị hình ảnh từ module feature_image
 */
$(".hidden-image").each(function () {
    viewImage($(this));
});

$(document).on("change", ".hidden-image", function () {
    viewImage($(this));
});

$(document).on("click", "label.select-image", function () {
    openQuickImages($(this).attr("for"));
});
//END Xử lý hiển thị hình ảnh từ module feature_image

/**
 * Xử lý table
 */
$(document).on("click", ".btn-create-table", function (e) {
    e.preventDefault();
    const form = $("#table-form");
    resetForm(form);
    form.attr("action", general.routes.table.create);
    form.find(".modal").modal("show");
});

$(document).on("click", ".btn-update-table", function () {
    const form = $("#table-form");
    resetForm(form);
    form.attr("action", general.routes.table.update);
    const id = $(this).attr("data-id");
    $.get(`table/get/${id}`, function (table) {
        form.find(`[name='id']`).val(table.id);
        form.find(`[name='name']`).val(table.name);
        form.find(`[name='area']`).val(table.area);
        form.find(`[name='sort']`).val(table.sort);
        form.find(`[name='note']`).val(table.note);
        form.find(".modal").modal("show");
    });
});

/**
 * Xử lý product
 */
$(".btn-create-product").click(function (e) {
    const form = $("#product-form");
    const input = $(".hidden-image");
    e.preventDefault();
    resetForm(form);
    $(`label[for='${input.attr("id")}']`)
        .find("img")
        .attr("src", general.routes.storageDir + "/" + "placeholder.png");
    input.parents(".card").find(".btn-remove-image").addClass("d-none");
    form.attr("action", general.routes.product.create);
    form.find(".modal").modal("show");
});

//Khi người dùng ấn nút cập nhật
$(document).on("click", ".btn-update-product", function () {
    const form = $("#product-form");
    const id = $(this).attr("data-id");
    resetForm(form);
    form.attr("action", general.routes.product.update);
    $.get(`${general.routes.product.get}/${id}`, function (product) {
        form.find(`[name='id']`).val(product.id);
        form.find(`[name='name']`).val(product.name);
        form.find(`[name='catalogue_id']`).val(product.catalogue_id);
        form.find(`[name='image']`).val(product.image);
        viewImage(form.find("[name=image]"));
        form.find(`[name='unit']`).val(product.unit);
        form.find(`[name='price']`).val(product.price);
    });
    form.find(".modal").modal("show");
});
/**
 * Xử lý tìm kiếm ajax-search
 */
$('.search-form input').on('keyup', debounce(function () {
    handleSearch($(this));
}, 300)).on('blur', function () {
    setTimeout(() => {
        const search_result = $(this).closest('.ajax-search').find('.search-result')
        search_result.removeClass('show');
    }, 500);
});

function handleSearch(input) {
    console.log(input);
    const searchTerm = input.val(),
        search_result = input.closest('.ajax-search').find('.search-result')
    result = input.closest('.row').find('.search-result');
    if (searchTerm != '') {
        $.get(`${input.attr('data-url')}&q=${searchTerm}`, function (response) {
            if (response.length) {
                search_result.html(response).addClass('show')
                setupArrowNavigation();
            } else {
                search_result.html(`
                    <li>
                        <div class="row p-0 mx-0">
                            <div class="col-12 py-3 text-center">
                                Không có hàng hóa nào phù hợp với tìm kiếm
                            </div>
                        </div>
                    </li>`).addClass('show')
            }
        })
    } else {
        search_result.removeClass('show')
    }
}

function debounce(func, delay) {
    let timeoutId;
    return function () {
        const context = this;
        const args = arguments;
        clearTimeout(timeoutId);
        timeoutId = setTimeout(function () {
            func.apply(context, args);
        }, delay);
    };
}

function setupArrowNavigation() {
    const items = $('.search-result .dropdown-item');
    let selectedIndex = -1;

    $(document).off('keydown').on('keydown', function (e) {
        switch (e.key) {
            case 'ArrowDown':
                if (selectedIndex < items.length - 1) {
                    selectedIndex++;
                    items.removeClass('active');
                    items.eq(selectedIndex).addClass('active');
                }
                break;
            case 'ArrowUp':
                if (selectedIndex > 0) {
                    selectedIndex--;
                    items.removeClass('active');
                    items.eq(selectedIndex).addClass('active');
                }
                break;
            case 'Enter':
                if (selectedIndex >= 0) {
                    items.eq(selectedIndex)[0].click();
                }
                break;
            case 'Escape':
                $('.search-form input').val('').focus();
                $('.search-result').removeClass('show');
                break;
            default:
                break;
        }
    });
}
