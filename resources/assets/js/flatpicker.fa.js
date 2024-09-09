
$(function(){
  console.log("FA FlatPicker JS");
  var Persian = {
    weekdays: {
      shorthand: ['ی', 'د', 'س', 'چ', 'پ', 'ج', 'ش'],
      longhand: [
        "یک‌شنبه",
        "دوشنبه",
        "سه‌شنبه",
        "چهارشنبه",
        "پنچ‌شنبه",
        "جمعه",
        "شنبه",
      ],
    },
    months: {
      shorthand: [
        "فروردین",
        "اردیبهشت",
        "خرداد",
        "تیر",
        "مرداد",
        "شهریور",
        "مهر",
        "آبان",
        "آذر",
        "دی",
        "بهمن",
        "اسفند",
      ],
      longhand: [
        "فروردین",
        "اردیبهشت",
        "خرداد",
        "تیر",
        "مرداد",
        "شهریور",
        "مهر",
        "آبان",
        "آذر",
        "دی",
        "بهمن",
        "اسفند",
      ],
    },
    ordinal: function () {
      return "";
    },
    amPM: ["ق.ظ", "ب.ظ"],
  };
  flatpickr.l10ns.fa = Persian;
  flatpickr.localize(flatpickr.l10ns.fa = Persian);
})
