/**
 * App User View - Suspend User Script
 */
'use strict';
import axios from 'axios';

(function () {
  const suspendUser = document.querySelector('.suspend-user');

  // Suspend User javascript
  if (suspendUser) {
    suspendUser.onclick = function () {
      Swal.fire({
        title: 'هشدار!',
        text: 'پس از حذف کاربر، شما فاکتور های ثبت شده توسط کاربر را نیز پاک میکنید',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'بله حذف کن!',
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
            .delete(`/api/admins/${window.adminId}`, {
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
                text: 'کاربر مورد نظر به همراه فاکتور های آن حذف شد',
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
    };
  }

  //? Billing page have multiple buttons
  // Cancel Subscription alert
  const cancelSubscription = document.querySelectorAll('.cancel-subscription');

  // Alert With Functional Confirm Button
  if (cancelSubscription) {
    cancelSubscription.forEach(btnCancle => {
      btnCancle.onclick = function () {
        Swal.fire({
          text: 'آیا می خواهید اشتراک را لغو کنید؟',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'بله',
          customClass: {
            confirmButton: 'btn btn-primary me-2 waves-effect waves-light',
            cancelButton: 'btn btn-label-secondary waves-effect waves-light'
          },
          buttonsStyling: false
        }).then(function (result) {
          if (result.value) {
            Swal.fire({
              icon: 'success',
              title: 'اشتراک لغو شد!',
              text: 'اشتراک با موفقیت لغو شد.',
              customClass: {
                confirmButton: 'btn btn-success waves-effect waves-light'
              }
            });
          } else if (result.dismiss === Swal.DismissReason.cancel) {
          }
        });
      };
    });
  }
})();
