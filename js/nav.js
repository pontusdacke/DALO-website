$(document).ready(function() {
  $("[href]").each(function() {
    if (this.href == window.location.href) {
        $(this).parent("li").addClass("active");
    }
  });
});
