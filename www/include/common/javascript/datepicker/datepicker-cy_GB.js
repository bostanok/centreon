/* Welsh/UK initialisation for the jQuery UI date picker plugin. */
/* Written by William Griffiths. */
( function( factory ) {
	if ( typeof define === "function" && define.amd ) {

		// AMD. Register as an anonymous module.
		define( [ "../widgets/datepicker" ], factory );
	} else {

		// Browser globals
		factory( jQuery.datepicker );
	}
}( function( datepicker ) {
//To facilitate the library's integration into Centreon, we slightly modified its regional parameter.
datepicker.regional[ "cy_GB" ] = {
	closeText: "Done",
	prevText: "Prev",
	nextText: "Next",
	currentText: "Today",
	monthNames: [ "Ionawr","Chwefror","Mawrth","Ebrill","Mai","Mehefin",
	"Gorffennaf","Awst","Medi","Hydref","Tachwedd","Rhagfyr" ],
	monthNamesShort: [ "Ion", "Chw", "Maw", "Ebr", "Mai", "Meh",
	"Gor", "Aws", "Med", "Hyd", "Tac", "Rha" ],
	dayNames: [
		"Dydd Sul",
		"Dydd Llun",
		"Dydd Mawrth",
		"Dydd Mercher",
		"Dydd Iau",
		"Dydd Gwener",
		"Dydd Sadwrn"
	],
	dayNamesShort: [ "Sul", "Llu", "Maw", "Mer", "Iau", "Gwe", "Sad" ],
	dayNamesMin: [ "Su","Ll","Ma","Me","Ia","Gw","Sa" ],
	weekHeader: "Wy",
	dateFormat: "dd/mm/yy",
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: "" };
datepicker.setDefaults( datepicker.regional[ "cy_GB" ] );

return datepicker.regional[ "cy_GB" ];

} ) );
