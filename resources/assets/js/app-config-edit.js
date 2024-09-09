$(function () {
  var user_list_select = $('.users-list-select');
  if (user_list_select.length) {
    var $this = user_list_select;
    $this.select2({
      // placeholder: '',
      // dropdownParent: $('#canvasAddCustomConfig'),
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
})
