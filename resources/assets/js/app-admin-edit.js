$(function(){
    const fv = FormValidation.formValidation(document.getElementById('editAdminForm'), {
        fields: {
          password: {
            validators: {
              notEmpty: {
                message: 'رمز عبور را وارد کنید'
              },
              stringLength: {
                min: 6,
                message: 'رمز عبور باید حداقل 6 کاراکتر باشد'
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
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: function (field, ele) {
              return '.mb-3';
            }
          }),
          autoFocus: new FormValidation.plugins.AutoFocus()
        }
      });

})