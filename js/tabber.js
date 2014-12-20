(function($)  {
$(".single_tabber_content").hide();
$("ul.simple_tabber_menu li:first").addClass("active").show();
$(".single_tabber_content:first").show();
$("ul.simple_tabber_menu li").click(function() {
$("ul.simple_tabber_menu li").removeClass("active");
$(this).addClass("active");
$(".single_tabber_content").hide();
var activeTab = $(this).find("a").attr("href");
//$(activeTab).fadeIn();
if ($.browser.msie) {$(activeTab).show();}
else {$(activeTab).fadeIn();}
return false;
});
})(jQuery);
