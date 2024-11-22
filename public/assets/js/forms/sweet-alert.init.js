!(function ($) {
    "use strict";
  
    var SweetAlert = function () {};
  
    //examples
    (SweetAlert.prototype.init = function () {
      //Basic
      $("#sa-basic").click(function () {
        Swal.fire("Here's a message!");
      });
  
      //A title with a text under
      $("#sa-title").click(function () {
        Swal.fire(
          "Here's a message!",
          "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat eleifend ex semper, lobortis purus sed."
        );
      });
  
      //Success Message
      $("#sa-success").click(function () {
        Swal.fire(
          "Good job!",
          "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat eleifend ex semper, lobortis purus sed.",
          "success"
        );
      });
  
      //Warning Message
      $("#sa-warning").click(function () {
        Swal.fire(
          {
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false,
          },
          function () {
            swal("Deleted!", "Your imaginary file has been deleted.", "success");
          }
        );
      });
  
      //Custom Image
      $("#sa-image").click(function () {
        Swal.fire({
          title: "Govinda!",
          text: "Recently joined twitter",
          imageUrl: "../../dist/images/profile/user-2.jpg",
        });
      });
  
      //Auto Close Timer
      $("#sa-close").click(function () {
        Swal.fire({
          title: "Auto close alert!",
          text: "I will close in 2 seconds.",
          timer: 2000,
          showConfirmButton: false,
        });
      });
  
      $("#model-error-icon").click(function () {
        Swal.fire({
          type: "error",
          title: "Oops...",
          text: "Something went wrong!",
          footer: "<a href>Why do I have this issue?</a>",
        });
      });
  
      $("#sa-html").click(function () {
        Swal.fire({
          title: "<strong>HTML <u>example</u></strong>",
          type: "info",
          html:
            "You can use <b>bold text</b>, " +
            '<a href="//github.com">links</a> ' +
            "and other HTML tags",
          showCloseButton: true,
          showCancelButton: true,
          focusConfirm: false,
          confirmButtonText: '<i class="ti ti-thumb-up-filled"></i> Great!',
          confirmButtonAriaLabel: "Thumbs up, great!",
          cancelButtonText: '<i class="ti ti-thumb-down-filled"></i>',
          cancelButtonAriaLabel: "Thumbs down",
        });
      });
  
      $("#sa-position").click(function () {
        Swal.fire({
          position: "top-end",
          type: "success",
          title: "Your work has been saved",
          showConfirmButton: false,
          timer: 1500,
        });
      });
  
      $("#sa-animation").click(function () {
        Swal.fire({
          title: "Custom animation with Animate.css",
          animation: false,
          customClass: {
            popup: "animated tada",
          },
        });
      });
  
      $("#sa-confirm").click(function () {
        Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        }).then((result) => {
          if (result.value) {
            Swal.fire("Deleted!", "Your file has been deleted.", "success");
          }
        });
      });
    }),
      //init
      ($.SweetAlert = new SweetAlert()),
      ($.SweetAlert.Constructor = SweetAlert);
  })(window.jQuery),
    //initializing
    (function ($) {
      "use strict";
      $.SweetAlert.init();
    })(window.jQuery);
  