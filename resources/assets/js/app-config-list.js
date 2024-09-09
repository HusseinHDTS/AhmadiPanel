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

  // Variable declaration for table
  var dt_user_table = $('.datatables-configs'),
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
  var user_list_select = $('.users-list-select');
  if (user_list_select.length) {
    var $this = user_list_select;
    $this.select2({
      // placeholder: '',
      dropdownParent: $('#canvasAddCustomConfig'),
      language: {
        searching: function () {
          return 'درحال جستجو...'; // Custom loading text
        },
        noResults: function () {
          return 'کاربری یافت نشد'; // Custom no results text
        }
      },
      ajax: {
        url: '/api/user-names',
        dataType: 'json',
        beforeSend: function (xhr) {
          xhr.setRequestHeader('Authorization', 'Bearer ' + window.apiToken); // Replace 'token' with your actual token variable
        },
        data: function (params) {
          return {
            q: params.term // search term
          };
        },
        processResults: function (data) {
          let results = $.map(data, function (item) {
            return {
              id: item.id,
              text: item.username // Mapping here
            };
          });

          // Prepend the empty option
          results.unshift({
            id: '',
            text: 'همه کاربران' // Text displayed for the deselect option
          });

          return {
            results: results
          };
        },
      }
    });
  }
  var data_submit = $('.data-submit');
  if (data_submit) {
    var $this = data_submit;
    $this.on('click', function () {
      var $form = $('.add-new-config')
      var items = {};
      $form.find('input').each(function () {
        var $name = $(this).attr('name');
        var $value = $(this).val();
        items[$name] = $value;
      })
      $form.find('textarea').each(function () {
        var $name = $(this).attr('name');
        var $value = $(this).val();
        items[$name] = $value;
      })
      $form.find('select').each(function () {
        var $name = $(this).attr('name');
        items[$name] = $(this).val();
      })
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
      axios.post('/api/configs', items, {
        headers: {
          Authorization: `Bearer ${window.apiToken}`,
          'Content-Type': 'application/json'
        }
      }).then(data => {
        $.unblockUI();
        $.blockUI({
          message: '<p class="mb-0">عملیات موفق</p>',
          timeout: 3000,
          css: {
            backgroundColor: 'transparent',
            color: '#fff',
            border: '0'
          },
          overlayCSS: {
            opacity: 0.6
          }
        });
        window.location.href = '/app/config/list';
      })
        .catch(error => {
          console.log(error);
          $.unblockUI();
          $.blockUI({
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
    })
  }

  // Users datatable
  if (dt_user_table.length) {
    var dt_user = dt_user_table.DataTable({
      // processing: true,
      // serverSide: true,
      ajax: {
        url: '/api/configs',
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
          // User full name and email
          targets: 1,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            console.log(full);
            return full['order'];
          }
        },
        {
          // User full name and email
          targets: 2,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            console.log(full);
            return full['title'];
          }
        },
        {
          // User Role
          targets: 3,
          render: function (data, type, full, meta) {
            return full['internet_type'];
          }
        },
        {
          // User Status
          targets: 4,
          render: function (data, type, full, meta) {
            if (full['assigned_to']) {
              return `خیر`;
            } else {
              return `بله`;
            }
          }
        },
        {
          // User Status
          targets: 5,
          render: function (data, type, full, meta) {
            if (full['user']) {
              return `<a href="/users/${full['user']['id']}">${full['user']['username']}</a>`;
            } else {
              return "همه";
            }
          }
        },
        {
          // User Status
          targets: 6,
          render: function (data, type, full, meta) {
            function limitString(str, maxLength = 32) {
              if (str.length > maxLength) {
                return str.substring(0, maxLength) + '...';
              }
              return str;
            }
            return limitString(full['config']);
          }
        },
        {
          // User Status
          targets: 7,
          render: function (data, type, full, meta) {
            if (full['active'] == "true") {
              var $badge_class = 'bg-label-success';
              return '<span class="badge ' + $badge_class + '" > فعال </span>';
            } else {
              var $badge_class = 'bg-label-danger';
              return '<span class="badge ' + $badge_class + '" > غیرفعال </span>';
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
            var configUrl = `/app/config/${full['id']}`;
            var activeString = "";
            if (full['active'] == "true") {
              activeString = "غیرفعال کردن";
            } else {
              activeString = "فعال کردن";
            }
            return (
              '<div class="d-flex align-items-center">' +
              // `<a href="${userView}/${full['id']}" class="text-body"><i class="ti ti-edit ti-sm me-2"></i></a>` +
              // '<a href="javascript:;" class="text-body delete-record"><i class="ti ti-trash ti-sm mx-2"></i></a>' +
              '<a href="javascript:;" class="text-body dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm mx-1"></i></a>' +
              '<div class="dropdown-menu dropdown-menu-end m-0">' +
              `<a href="${configUrl}" class="dropdown-item">ویرایش</a>` +
              `<a href="${configUrl}/delete" class="dropdown-item">حذف</a>` +
              `<a href="${configUrl}/toggle" class="dropdown-item">${activeString}</a>` +
              '</div>' +
              '</div>'
            );
          }
        }
      ],
      order: [[1, 'desc']],
      dom:
        '<"row me-2"' +
        '<"col-md-2"<"me-3"l>>' +
        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
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
          text: '<span class="d-none d-sm-inline-block">افزودن کانفیگ</span><i class="ti ti-settings ms-0 ms-sm-1 ti-xs"></i>',
          className: 'add-new btn btn-primary waves-effect waves-light mx-3',
          attr: {
            'data-bs-toggle': 'offcanvas',
            'data-bs-target': '#canvasAddCustomConfig'
          }
        }
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
      }
    });
  }

  // Delete Record
  $('.datatables-users tbody').on('click', '.delete-record', function () {
    dt_user.row($(this).parents('tr')).remove().draw();
  });

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});

// Validation & Phone mask
(function () {
  const phoneMaskList = document.querySelectorAll('.phone-mask'),
    addNewUserForm = document.getElementById('addNewConfigForm');

  // Phone Number
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
            min: 8,
            message: 'رمز عبور باید حداقل 8 کاراکتر باشد'
          },
        }
      },
      repassword: {
        validators: {
          notEmpty: {
            message: 'تایید رمز عبور را وارد کنید'
          },
          identical: {
            compare: function () {
              return addNewUserForm.querySelector('[name="password"]').value;
            },
            message: 'رمز عبور و تایید آن یکسان نیستند'
          }
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
            message: 'تعداد نشست‌های فعال باید حداقل 1 باشد'
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
            min: 0,
            message: 'حجم مجاز باید حداقل 0 باشد'
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
            message: 'تعداد روز های مجاز باید حداقل 1 باشد'
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
