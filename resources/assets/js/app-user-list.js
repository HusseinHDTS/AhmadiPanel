/**
 * Page User List
 */

'use strict';
import axios from 'axios';

// Datatable (jquery)
$(function () {
  let borderColor, bodyBg, headingColor;

  if (isDarkStyle) {
    borderColor = config.colors_dark.borderColor;
    bodyBg = config.colors_dark.bodyBg;
    headingColor = config.colors_dark.headingColor;
  } else {
    borderColor = config.colors.borderColor;
    bodyBg = config.colors.bodyBg;
    headingColor = config.colors.headingColor;
  }

  $(document).on('click', '.remove-expired-users', function () {
    Swal.fire({
      title: 'هشدار!',
      text: 'پس از حذف کاربر دیگر قابلیت بازگشت عملیات وجود ندارد',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'حذف کن!',
      cancelButtonText: 'لغو',
      customClass: {
        confirmButton: 'btn btn-primary me-2 waves-effect waves-light',
        cancelButton: 'btn btn-label-secondary waves-effect waves-light'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.value) {
        $.blockUI({
          message:
            '<div class="d-flex justify-content-center"><p class="mb-0 mx-2">منتظر بمانید...</p> <div class="sk-wave m-0"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
          css: {
            backgroundColor: 'transparent',
            color: '#fff',
            border: '0'
          },
          overlayCSS: {
            opacity: 0.8
          }
        });
        axios
          .delete(`/api/users/remove-expired`, {
            headers: {
              Authorization: `Bearer ${window.apiToken}`,
              'Content-Type': 'application/json'
            }
          })
          .then(data => {
            $.unblockUI();
            Swal.fire({
              icon: 'success',
              title: 'حذف شد!',
              text: 'کاربر مورد نظر به همراه حذف شد',
              confirmButtonText: 'باشه',
              customClass: {
                confirmButton: 'btn btn-success waves-effect waves-light'
              }
            }).then(function (result) {
              window.location.href = '/app/user/list';
            });
          })
          .catch(error => {
            $.unblockUI();
            $('.wizard-icons-invoice').block({
              message: '<p class="mb-0">عملیات نا موفق</p><div>' + JSON.stringify(error) + '</div>',
              timeout: 3000,
              css: {
                backgroundColor: 'transparent',
                color: '#fff',
                border: '0'
              },
              overlayCSS: {
                opacity: 0.25
              }
            });
          });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        // can do any thing
      }
    });
  })

  function convertMilliseconds(ms) {
    let seconds = Math.floor(ms / 1000);
    let minutes = Math.floor(seconds / 60);
    let hours = Math.floor(minutes / 60);
    let days = Math.floor(hours / 24);

    hours = hours % 24;
    minutes = minutes % 60;
    seconds = seconds % 60;

    return {
      days: days,
      hours: hours,
      minutes: minutes,
      seconds: seconds
    };
  }
  // Variable declaration for table
  var dt_user_table = $('.datatables-users'),
    select2 = $('.select2'),
    userView = baseUrl + 'app/user/view/account',
    statusObj = {
      1: { title: 'درانتظار', class: 'bg-label-warning' },
      2: { title: 'فعال', class: 'bg-label-success' },
      3: { title: 'غیرفعال', class: 'bg-label-secondary' }
    };

  if (select2.length) {
    var $this = select2;
    $this.wrap('<div class="position-relative"></div>').select2({
      placeholder: 'انتخاب کشور',
      dropdownParent: $this.parent()
    });
  }

  // Users datatable
  if (dt_user_table.length) {
    var dt_user = dt_user_table.DataTable({
      // processing: true,
      // serverSide: true,
      lengthChange: false,
      pageLength: 100,
      ajax: {
        url: '/api/admins',
        type: 'GET',
        beforeSend: function (xhr) {
          xhr.setRequestHeader('Authorization', 'Bearer ' + window.apiToken); // Replace 'token' with your actual token variable
        }
      },
      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'id' },
        { data: 'id' },
        { data: 'id' },
        { data: 'id' },
        { data: 'id' },
        { data: 'id' },
        { data: 'id' },
        { data: 'id' },
        { data: 'id' }
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          searchable: false,
          orderable: false,
          responsivePriority: 2,
          targets: 0,
          render: function (data, type, full, meta) {
            return '';
          }
        },
        {
          // User Role
          targets: 1,
          render: function (data, type, full, meta) {
            return full['internet_type'];
          }
        },
        {
          // User full name and email
          targets: 2,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            return full['username'];
          }
        },
        {
          // User Status
          targets: 3,
          render: function (data, type, full, meta) {
            return full['password'];
          }
        },
        {
          // User Status
          targets: 4,
          render: function (data, type, full, meta) {
            return full['max_active_session'] || "0";
          }
        },
        {
          // User Status
          targets: 5,
          render: function (data, type, full, meta) {
            return full['active_sessions'] || "0";
          }
        },
        {
          // User Status
          targets: 6,
          render: function (data, type, full, meta) {
            return `${full['sub_days']} روز`;
          }
        },
        {
          // User Status
          targets: 7,
          render: function (data, type, full, meta) {
            var hasSub = true;
            let remainingTime = convertMilliseconds(full['remaining_milliseconds']);
            var sum = remainingTime.hours + remainingTime.days + remainingTime.minutes + remainingTime.seconds;
            if(sum <= 0){
              hasSub = false;
            }
            if (hasSub > 0) {
              return `${remainingTime.days} روز ${remainingTime.hours} ساعت ${remainingTime.minutes} دقیقه`;
            } else {
              return `<span class="badge bg-label-danger">اعتبار تمام شده است</span>`;
            }
          }
        },
        {
          // User Status
          targets: 8,
          render: function (data, type, full, meta) {
            var $status = full['status'];
            if ($status == "active") {
              return `<span class="badge bg-label-success">فعال</span>`;
            } else {
              return `<span class="badge bg-label-danger">غیرفعال</span>`;
            }
          }
        },
        {
          // Actions
          targets: -1,
          title: 'عملیات',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            var userUrl = `/app/user/list/${full['id']}`;
            var statusString = "";
            if (full['status'] == "active") {
              statusString = "غیرفعال کردن";
            } else {
              statusString = "فعال کردن";
            }
            return (
              '<div class="d-flex align-items-center">' +
              '<a href="javascript:;" class="text-body dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm mx-1"></i></a>' +
              '<div class="dropdown-menu dropdown-menu-end m-0">' +
              `<a href="${userUrl}" class="dropdown-item">ویرایش</a>` +
              `<a href="${userUrl}/delete" class="dropdown-item">حذف کاربر</a>` +
              `<a href="${userUrl}/toggle" class="dropdown-item">${statusString}</a>` +
              `<a href="${userUrl}/resetVolume" class="dropdown-item">تمدید حجم</a>` +
              `<a href="${userUrl}/resetDays" class="dropdown-item">تمدید اعتبار</a>` +
              `<a href="${userUrl}/removeActiveSessions" class="dropdown-item">حذف سشن های فعال</a>` +
              '</div>' +
              '</div>'
            );
          }
        }
      ],
      // order: [[3, 'desc']],
      dom:
        '<"row me-2"' +
        // '<"col-md-2"<"me-3"l>>' +
        '<"col-md-12"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 user_status mb-md-0"fB>>' +
        '>t' +
        '<"row mx-2"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      language: {
        url: assetsPath + 'json/i18n/datatables-bs5/fa.json',
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'جستجو..'
      },
      // Buttons with Dropdown
      buttons: [
        {
          text: '<i class="ti ti-trash me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">حذف کاربران منقضی شده</span>',
          className: 'add-new btn btn-outline-danger waves-effect waves-light mx-3 remove-expired-users',
        },
        {
          text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">افزودن کاربر</span>',
          className: 'add-new btn btn-primary waves-effect waves-light mx-3',
          attr: {
            'data-bs-toggle': 'offcanvas',
            'data-bs-target': '#offcanvasAddUser'
          }
        },
      ],
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'جزئیات ' + data['name'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                ? '<tr data-dt-row="' +
                col.rowIndex +
                '" data-dt-column="' +
                col.columnIndex +
                '">' +
                '<td>' +
                col.title +
                ':' +
                '</td> ' +
                '<td>' +
                col.data +
                '</td>' +
                '</tr>'
                : '';
            }).join('');

            return data ? $('<table class="table"/><tbody />').append(data) : false;
          }
        }
      },
      initComplete: function () {
        const table = this;
        this.api()
          .columns(1)
          .every(function () {
            var column = this;
            var internetTypeHolder = $('<div class="col-md-2 col-12"></div>');
            var internetTypeSelect = $(
              '<select class="form-select status-filter me-2"><option value=""> فیلتر خط... </option></select>'
            )
              .on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                // console.log(val);
                column.search(val ? val : '').draw();
              });
            internetTypeSelect.append(`<option value="irancel" class="text-capitalize">ایرانسل</option>`);
            internetTypeSelect.append(`<option value="hamrah" class="text-capitalize">همراه اول</option>`);
            internetTypeSelect.append(`<option value="rightel" class="text-capitalize">رایتل</option>`);
            internetTypeSelect.append(`<option value="wifi" class="text-capitalize">وایفای</option>`);
            internetTypeHolder.append(internetTypeSelect);
            internetTypeHolder.prependTo('.user_status');
            ///
          });

        this.api()
          .columns(5)
          .every(function () {
            var column = this;
            var userTypeHolder = $('<div class="col-md-2 col-12"></div>');
            var userTypeSelect = $(
              '<select class="form-select status-filter me-2"><option value=""> کاربر... </option></select>'
            )
              .on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                if (val == "not_sign_in") {
                  column.search('^0$', true, false, true).draw();
                }else if(val=="signed_in"){
                  column.search('^(?!0$).*$', true, false, true).draw();
                } else {
                  column.search('').draw();
                }
              });
            userTypeSelect.append(`<option value="" class="text-capitalize">همه</option>`);
            userTypeSelect.append(`<option value="not_sign_in" class="text-capitalize">وارد اکانت خود نشده اند</option>`);
            userTypeSelect.append(`<option value="signed_in" class="text-capitalize">وارد اکانت خود شده اند</option>`);
            userTypeHolder.append(userTypeSelect);
            userTypeHolder.prependTo('.user_status');
            ///
          });
          var userTypeHolder = $('<div class="col-md-2 col-12"></div>');
          var userTypeSelect = $(
            '<select class="form-select status-filter me-2"><option value="">اعتبار...</option></select>'
          )
            .on('change', function () {
              var val = $(this).val();
              $.fn.dataTable.ext.search.splice(0, $.fn.dataTable.ext.search.length);
              if (val === "") {
                table.api().columns().draw();  // Just redraw the table without any filtering
                return;
              }

              $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                var rowData = settings.aoData[dataIndex]._aData;  // Get raw row data
                let remainingMilliseconds = rowData['remaining_milliseconds'];  // Get remaining time in milliseconds
                let remainingTime = convertMilliseconds(remainingMilliseconds);  // Convert to days, hours, etc.
                var expired = (remainingTime.days <= 0 && remainingTime.hours <= 0 && remainingTime.minutes <= 0);
                if (val === "expired") {
                  return expired;
                } else if (val === "one_day_left") {
                  return remainingTime.days <= 1 && (!expired);
                } else {
                  return true; 
                }
              });
              table.api().columns().draw();
            });

          userTypeSelect.append(`<option value="" class="text-capitalize">همه</option>`);
          userTypeSelect.append(`<option value="expired" class="text-capitalize">منقضی شده</option>`);
          userTypeSelect.append(`<option value="one_day_left" class="text-capitalize">یک روز مانده</option>`);
          userTypeHolder.append(userTypeSelect);
          userTypeHolder.prependTo('.user_status');
      }
    });
  }

  $('.datatables-users tbody').on('click', '.delete-record', function () {
    dt_user.row($(this).parents('tr')).remove().draw();
  });

  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});

(function () {
  const phoneMaskList = document.querySelectorAll('.phone-mask'),
    addNewUserForm = document.getElementById('addNewUserForm');

  if (phoneMaskList) {
    phoneMaskList.forEach(function (phoneMask) {
      new Cleave(phoneMask, {
        phone: true
      });
    });
  }
  // Add New User Form Validation
  const fv = FormValidation.formValidation(addNewUserForm, {
    fields: {
      username: {
        validators: {
          notEmpty: {
            message: 'نام کامل را وارد کنید'
          }
        }
      },
      password: {
        validators: {
          notEmpty: {
            message: 'رمز عبور را وارد کنید'
          },
          stringLength: {
            min: 2,
            message: 'رمز عبور باید حداقل 2 کاراکتر باشد'
          },
        }
      },
      max_active_session: {
        validators: {
          notEmpty: {
            message: 'تعداد نشست‌های فعال را وارد کنید'
          },
          numeric: {
            message: 'این فیلد باید یک عدد باشد'
          },
          between: {
            min: 1,
            max: 10,
            message: 'تعداد نشست‌های فعال باید حداقل 1 و حداکثر 10 باشد'
          }
        }
      },
      max_volume: {
        validators: {
          notEmpty: {
            message: 'حجم مجاز را وارد کنید'
          },
          numeric: {
            message: 'این فیلد باید یک عدد باشد'
          },
          between: {
            min: 1,
            max: 100000,
            message: 'حجم مجاز باید حداقل 1 و حداکثر 100,000 باشد'
          }
        }
      },
      sub_days: {
        validators: {
          notEmpty: {
            message: 'تعداد روز های اشتراک را وارد کنید'
          },
          numeric: {
            message: 'این فیلد باید یک عدد باشد'
          },
          between: {
            min: 1,
            max: 365,
            message: 'تعداد روز های مجاز باید حداقل 1 و حداکثر 365 باشد'
          }
        }
      },
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        // Use this for enabling/changing valid/invalid class
        eleValidClass: '',
        rowSelector: function (field, ele) {
          // field is the field name & ele is the field element
          return '.mb-3';
        }
      }),
      // submitButton: new FormValidation.plugins.SubmitButton(),
      // Submit the form when all fields are valid
      // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  });
})();
