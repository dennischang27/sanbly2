/*=========================================================================================
    File Name: app-invoice.js
    Description: app-invoice Javascripts
    ----------------------------------------------------------------------------------------
    Item Name: Frest HTML Admin Template
   Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
$(document).ready(function () {
	
  /********Invoice View ********/
  // ---------------------------
  // init date picker
  if ($(".pickadate").length) {
    $(".pickadate").pickadate({
      format: "mm/dd/yyyy"
    });
  }

  /********Invoice List ********/
  // ---------------------------

  // init data table
  if ($(".invoice-data-table").length) {
	var searchPlaceholder = $(".invoice-data-table").data("search");
    var dataListView = $(".invoice-data-table").DataTable({
      columnDefs: [
        {
          targets: 0,
          className: "control"
        },
        {
          orderable: true,
          targets: 1,
          checkboxes: { selectRow: true }
        },
        {
          targets: [0, 1],
          orderable: false
        },
      ],
      order: [2, 'asc'],
      dom:
        '<"top d-flex flex-wrap"<"action-filters flex-grow-1"f><"actions action-btns d-flex align-items-center">><"clear">rt<"bottom"p>',
      language: {
        search: "",
        searchPlaceholder: searchPlaceholder
      },
      select: {
        style: "multi",
        selector: "td:first-child",
        items: "row"
      },
      responsive: {
        details: {
          type: "column",
          target: 0
        }
      }
    });
  }

  // To append actions dropdown inside action-btn div
  var invoiceFilterAction = $(".invoice-filter-action");
  var invoiceOptions = $(".invoice-options");
  $(".action-btns").append(invoiceFilterAction, invoiceOptions);

  // add class in row if checkbox checked
  $(".dt-checkboxes-cell")
    .find("input")
    .on("change", function () {
      var $this = $(this);
      if ($this.is(":checked")) {
        $this.closest("tr").addClass("selected-row-bg");
      } else {
        $this.closest("tr").removeClass("selected-row-bg");
      }
    });
  // Select all checkbox
  $(document).on("change", ".dt-checkboxes-select-all input", function () {
    if ($(this).is(":checked")) {
      $(".dt-checkboxes-cell")
        .find("input")
        .prop("checked", this.checked)
        .closest("tr")
        .addClass("selected-row-bg");
    } else {
      $(".dt-checkboxes-cell")
        .find("input")
        .prop("checked", "")
        .closest("tr")
        .removeClass("selected-row-bg");
    }
  });

  // ********Invoice Edit***********//
  // --------------------------------
  // form repeater jquery
  if ($(".invoice-item-repeater").length) {
    $(".invoice-item-repeater").repeater({
      show: function () {
        $(this).slideDown();
      },
      hide: function (deleteElement) {
        $(this).slideUp(deleteElement);
      }
    });
  }
  // dropdown form's prevent parent action
  $(document).on("click", ".invoice-tax", function (e) {
    e.stopPropagation();
  });
  $(document).on("click", ".invoice-apply-btn", function () {
    var $this = $(this);
    var discount = $this
      .closest(".dropdown-menu")
      .find("#discount")
      .val();
    var tax1 = $this
      .closest(".dropdown-menu")
      .find("#Tax1 option:selected")
      .text();
    var tax2 = $this
      .closest(".dropdown-menu")
      .find("#Tax2 option:selected")
      .text();
    $this
      .parents()
      .eq(4)
      .find(".discount-value")
      .html(discount + "%");
    $this
      .parents()
      .eq(4)
      .find(".tax1")
      .html(tax1);
    $this
      .parents()
      .eq(4)
      .find(".tax2")
      .html(tax2);
  });
  // // on product change also change product description
  $(document).on("change", ".invoice-item-select", function (e) {
    var selectOption = this.options[e.target.selectedIndex].text;
    // switch case for product select change also change product description
    switch (selectOption) {
      case "Frest Admin Template":
        $(e.target)
          .closest(".invoice-item-filed")
          .find(".invoice-item-desc")
          .val("The most developer friendly & highly customisable HTML5 Admin");
        break;
      case "Stack Admin Template":
        $(e.target)
          .closest(".invoice-item-filed")
          .find(".invoice-item-desc")
          .val("Ultimate Bootstrap 4 Admin Template for Next Generation Applications.");
        break;
      case "Robust Admin Template":
        $(e.target)
          .closest(".invoice-item-filed")
          .find(".invoice-item-desc")
          .val(
            "Robust admin is super flexible, powerful, clean & modern responsive bootstrap admin template with unlimited possibilities"
          );
        break;
      case "Apex Admin Template":
        $(e.target)
          .closest(".invoice-item-filed")
          .find(".invoice-item-desc")
          .val("Developer friendly and highly customizable Angular 7+ jQuery Free Bootstrap 4 gradient ui admin template. ");
        break;
      case "Modern Admin Template":
        $(e.target)
          .closest(".invoice-item-filed")
          .find(".invoice-item-desc")
          .val("The most complete & feature packed bootstrap 4 admin template of 2019!");
        break;
    }
  });
  // print button
  if ($(".invoice-print").length > 0) {
    $(".invoice-print").on("click", function () {
      window.print();
    })
  }
  
  const countryList = [
		"Afghanistan",
		"Albania",
		"Algeria",
		"American Samoa",
		"Andorra",
		"Angola",
		"Anguilla",
		"Antarctica",
		"Antigua and Barbuda",
		"Argentina",
		"Armenia",
		"Aruba",
		"Australia",
		"Austria",
		"Azerbaijan",
		"Bahamas (the)",
		"Bahrain",
		"Bangladesh",
		"Barbados",
		"Belarus",
		"Belgium",
		"Belize",
		"Benin",
		"Bermuda",
		"Bhutan",
		"Bolivia (Plurinational State of)",
		"Bonaire, Sint Eustatius and Saba",
		"Bosnia and Herzegovina",
		"Botswana",
		"Bouvet Island",
		"Brazil",
		"British Indian Ocean Territory (the)",
		"Brunei Darussalam",
		"Bulgaria",
		"Burkina Faso",
		"Burundi",
		"Cabo Verde",
		"Cambodia",
		"Cameroon",
		"Canada",
		"Cayman Islands (the)",
		"Central African Republic (the)",
		"Chad",
		"Chile",
		"China",
		"Christmas Island",
		"Cocos (Keeling) Islands (the)",
		"Colombia",
		"Comoros (the)",
		"Congo (the Democratic Republic of the)",
		"Congo (the)",
		"Cook Islands (the)",
		"Costa Rica",
		"Croatia",
		"Cuba",
		"Curaçao",
		"Cyprus",
		"Czechia",
		"Côte d'Ivoire",
		"Denmark",
		"Djibouti",
		"Dominica",
		"Dominican Republic (the)",
		"Ecuador",
		"Egypt",
		"El Salvador",
		"Equatorial Guinea",
		"Eritrea",
		"Estonia",
		"Eswatini",
		"Ethiopia",
		"Falkland Islands (the) [Malvinas]",
		"Faroe Islands (the)",
		"Fiji",
		"Finland",
		"France",
		"French Guiana",
		"French Polynesia",
		"French Southern Territories (the)",
		"Gabon",
		"Gambia (the)",
		"Georgia",
		"Germany",
		"Ghana",
		"Gibraltar",
		"Greece",
		"Greenland",
		"Grenada",
		"Guadeloupe",
		"Guam",
		"Guatemala",
		"Guernsey",
		"Guinea",
		"Guinea-Bissau",
		"Guyana",
		"Haiti",
		"Heard Island and McDonald Islands",
		"Holy See (the)",
		"Honduras",
		"Hong Kong",
		"Hungary",
		"Iceland",
		"India",
		"Indonesia",
		"Iran (Islamic Republic of)",
		"Iraq",
		"Ireland",
		"Isle of Man",
		"Israel",
		"Italy",
		"Jamaica",
		"Japan",
		"Jersey",
		"Jordan",
		"Kazakhstan",
		"Kenya",
		"Kiribati",
		"Korea (the Democratic People's Republic of)",
		"Korea (the Republic of)",
		"Kuwait",
		"Kyrgyzstan",
		"Lao People's Democratic Republic (the)",
		"Latvia",
		"Lebanon",
		"Lesotho",
		"Liberia",
		"Libya",
		"Liechtenstein",
		"Lithuania",
		"Luxembourg",
		"Macao",
		"Madagascar",
		"Malawi",
		"Malaysia",
		"Maldives",
		"Mali",
		"Malta",
		"Marshall Islands (the)",
		"Martinique",
		"Mauritania",
		"Mauritius",
		"Mayotte",
		"Mexico",
		"Micronesia (Federated States of)",
		"Moldova (the Republic of)",
		"Monaco",
		"Mongolia",
		"Montenegro",
		"Montserrat",
		"Morocco",
		"Mozambique",
		"Myanmar",
		"Namibia",
		"Nauru",
		"Nepal",
		"Netherlands (the)",
		"New Caledonia",
		"New Zealand",
		"Nicaragua",
		"Niger (the)",
		"Nigeria",
		"Niue",
		"Norfolk Island",
		"Northern Mariana Islands (the)",
		"Norway",
		"Oman",
		"Pakistan",
		"Palau",
		"Palestine, State of",
		"Panama",
		"Papua New Guinea",
		"Paraguay",
		"Peru",
		"Philippines (the)",
		"Pitcairn",
		"Poland",
		"Portugal",
		"Puerto Rico",
		"Qatar",
		"Republic of North Macedonia",
		"Romania",
		"Russian Federation (the)",
		"Rwanda",
		"Réunion",
		"Saint Barthélemy",
		"Saint Helena, Ascension and Tristan da Cunha",
		"Saint Kitts and Nevis",
		"Saint Lucia",
		"Saint Martin (French part)",
		"Saint Pierre and Miquelon",
		"Saint Vincent and the Grenadines",
		"Samoa",
		"San Marino",
		"Sao Tome and Principe",
		"Saudi Arabia",
		"Senegal",
		"Serbia",
		"Seychelles",
		"Sierra Leone",
		"Singapore",
		"Sint Maarten (Dutch part)",
		"Slovakia",
		"Slovenia",
		"Solomon Islands",
		"Somalia",
		"South Africa",
		"South Georgia and the South Sandwich Islands",
		"South Sudan",
		"Spain",
		"Sri Lanka",
		"Sudan (the)",
		"Suriname",
		"Svalbard and Jan Mayen",
		"Sweden",
		"Switzerland",
		"Syrian Arab Republic",
		"Taiwan",
		"Tajikistan",
		"Tanzania, United Republic of",
		"Thailand",
		"Timor-Leste",
		"Togo",
		"Tokelau",
		"Tonga",
		"Trinidad and Tobago",
		"Tunisia",
		"Turkey",
		"Turkmenistan",
		"Turks and Caicos Islands (the)",
		"Tuvalu",
		"Uganda",
		"Ukraine",
		"United Arab Emirates (the)",
		"United Kingdom of Great Britain and Northern Ireland (the)",
		"United States Minor Outlying Islands (the)",
		"United States of America (the)",
		"Uruguay",
		"Uzbekistan",
		"Vanuatu",
		"Venezuela (Bolivarian Republic of)",
		"Viet Nam",
		"Virgin Islands (British)",
		"Virgin Islands (U.S.)",
		"Wallis and Futuna",
		"Western Sahara",
		"Yemen",
		"Zambia",
		"Zimbabwe",
		"Aland Islands"
	];
	
	if(document.getElementById('countrySelect') !== null){
		var opt = document.createElement("option");
		document.getElementById("countrySelect").innerHTML += '<option value="" disabled selected>Country</option>';
		for (i = 0; i < countryList.length; i++) {
			var opt = document.createElement("option");
			document.getElementById("countrySelect").innerHTML += '<option value="' + countryList[i] + '">' + countryList[i] + '</option>';
		}
	}
	
	if(typeof customer_id != 'undefined'){
		$("select#customer").val(customer_id);
		$("#address").val(address);
		$("#city").val(city);
		$("#state").val(state);
		$("#zipcode").val(zipcode);
		$("#countrySelect").val(country);
	}
	
	$('#date_issue').click(function() {
		$('.picker').css('left', '40.2%');
	});
	
	$('#date_due').click(function() {
		$('.picker').css('left', '77.2%');
	});
	
	$('#payment_date').click(function() {
		$('.picker').css('top', '30.4%');
		var payment_date = $('#payment_date').val();
		var picker = $('#payment_date').pickadate('picker');
		picker.set('select', payment_date);
	});
});
