$(document).ready(function() {
    // $("input[name='REGISTER[PERSONAL_CITY]']").suggestions({
    //     // Замените на свой API-ключ
    //     token: "442de4f618e92a523ac2a8a77a64641358b08644",
    //     type: "ADDRESS",
    //     // Вызывается, когда пользователь выбирает одну из подсказок
    //     onSelect: function (suggestion) {
    //         console.log(suggestion);
    //     }
    // });
    var token = "442de4f618e92a523ac2a8a77a64641358b08644";
    var type  = "ADDRESS";
    var $region = $("input[name='REGISTER[PERSONAL_STATE]");
    var $city   = $("input[name='REGISTER[PERSONAL_CITY]");
    var $street = $("input[name='REGISTER[PERSONAL_STREET]");
    var $house  = $("input[name='REGISTER[TITLE]");

// регион и район
    $region.suggestions({
        token: token,
        type: type,
        hint: false,
        bounds: "region-area"
    });

// город и населенный пункт
    $city.suggestions({
        token: token,
        type: type,
        hint: false,
        bounds: "city-settlement",
        constraints: $region
    });

// Район
     $street.suggestions({
        token: token,
        type: type,
        hint: false,
        bounds: "city_district_type",
        constraints: $city,
        count: 15
    });
    // дом
    $house.suggestions({
        token: token,
        type: type,
        hint: false,
        noSuggestionsHint: false,
        bounds: "address",
        constraints: $street
    });

//suggestions-value
    $('.suggestions-value span').on('click',function (){
        console.log($(this).html())
    })
    $('input[name="REGISTER[PERSONAL_STREET]"]').keyup(async function (sug) {
        console.log($('.suggestions-suggestions div').html())
        //console.log(await sug)
        var arr = await $(this).suggestions().suggestions
        if(arr){
            for (var key in arr) {
                //console.log(arr[key].value);
            }
        }
    });




    // $("input[name='REGISTER[EMAIL]']").inputmask({
    //     mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
    //     greedy: false,
    //     onBeforePaste: function (pastedValue, opts) {
    //         pastedValue = pastedValue.toLowerCase();
    //         return pastedValue.replace("mailto:", "");
    //     },
    //     definitions: {
    //         '*': {
    //             validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
    //             cardinality: 1,
    //             casing: "lower"
    //         }
    //     }
    // });
    console.log('test');
    $(function() {
        let $input = $("input[name='REGISTER[EMAIL]']");
        let cursor = $input[0].selectionStart;
        let prev = $input.val();

        $input.inputmask({
            mask: "*{1,50}[.*{1,50}][.*{1,50}]@*{1,50}.*{1,20}[.*{1,20}][.*{1,20}]",
            greedy: false,
            clearIncomplete: true,
            showMaskOnHover: false,
            definitions: {
                '*': {
                    validator: "[^_@.]"
                }
            }
        }).on('keyup paste', function() {
            if (this.value && /[^_a-zA-Z0-9@\-.]/i.test(this.value)) {
                this.value = prev;
                this.setSelectionRange(cursor, cursor);
                $input.trigger('input');
            } else {
                cursor = this.selectionStart;
                prev = this.value;
            }
        });
    });

});



// улица
//     $street.suggestions({
//         token: token,
//         type: type,
//         hint: false,
//         bounds: "street",
//         constraints: $city,
//         count: 15
//     });






// const token = "442de4f618e92a523ac2a8a77a64641358b08644";
//
//
// function address_helper(query) {
//     var url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address";
//     var options = {
//         method: "POST",
//         mode: "cors",
//         headers: {
//             "Content-Type": "application/json",
//             "Accept": "application/json",
//             "Authorization": "Token " + token
//         },
//         body: JSON.stringify({query: query})
//     }
//
//     return fetch(url, options)
//         .then(function(response) {
//             return response.text();
//         })
//         .then(function(result) {
//         return result;
//         })
//         .catch(error => console.log("error", error));
//
//
// }
// console.log('test');
//
// const start = async function(query) {
//     const result = await address_helper(query);
//     parsedData = JSON.parse(result);
//     //console.log(parsedData.suggestions[1].value);
//     var arr_address = []
//     parsedData.suggestions.forEach(function (item, i, arr) {
//         arr_address.push(item.value)
//     });
//     //console.log(arr_address)
//     return arr_address;
// }
// $(document).ready(function() {
//     $('body').on('input',"input[name='REGISTER[PERSONAL_CITY]']", async function(){
//         if (this.value.length > 3){
//             var arr_address = await start(this.value)
//             console.log(arr_address)
//             $(this).autocomplete({
//                 source: arr_address,
//                 minLength: 0
//             });
//         }
//     });
//
// });
//https://codepen.io/dadata/pen/pPwPVJ
// Call start
// const result_address = start();
// console.log(result_address);
//console.log(await address_helper('г Москва, ул Тв'));
//var puls = {"suggestions":[{"value":"г Москва, ул Тверская","unrestricted_value":"г Москва, Тверской р-н, ул Тверская","data":{"postal_code":null,"country":"Россия","country_iso_code":"RU","federal_district":"Центральный","region_fias_id":"0c5b2444-70a0-4932-980c-b4dc0d3f02b5","region_kladr_id":"7700000000000","region_iso_code":"RU-MOW","region_with_type":"г Москва","region_type":"г","region_type_full":"город","region":"Москва","area_fias_id":null,"area_kladr_id":null,"area_with_type":null,"area_type":null,"area_type_full":null,"area":null,"city_fias_id":"0c5b2444-70a0-4932-980c-b4dc0d3f02b5","city_kladr_id":"7700000000000","city_with_type":"г Москва","city_type":"г","city_type_full":"город","city":"Москва","city_area":"Центральный","city_district_fias_id":null,"city_district_kladr_id":null,"city_district_with_type":null,"city_district_type":null,"city_district_type_full":null,"city_district":null,"settlement_fias_id":null,"settlement_kladr_id":null,"settlement_with_type":null,"settlement_type":null,"settlement_type_full":null,"settlement":null,"street_fias_id":"0ecde158-a58f-43af-9707-aa6dd3484b56","street_kladr_id":"77000000000287700","street_with_type":"ул Тверская","street_type":"ул","street_type_full":"улица","street":"Тверская","stead_fias_id":null,"stead_cadnum":null,"stead_type":null,"stead_type_full":null,"stead":null,"house_fias_id":null,"house_kladr_id":null,"house_cadnum":null,"house_type":null,"house_type_full":null,"house":null,"block_type":null,"block_type_full":null,"block":null,"entrance":null,"floor":null,"flat_fias_id":null,"flat_cadnum":null,"flat_type":null,"flat_type_full":null,"flat":null,"flat_area":null,"square_meter_price":null,"flat_price":null,"room_fias_id":null,"room_cadnum":null,"room_type":null,"room_type_full":null,"room":null,"postal_box":null,"fias_id":"0ecde158-a58f-43af-9707-aa6dd3484b56","fias_code":null,"fias_level":"7","fias_actuality_state":"0","kladr_id":"77000000000287700","geoname_id":"524901","capital_marker":"0","okato":"45286585000","oktmo":"45382000","tax_office":"7710","tax_office_legal":"7710","timezone":null,"geo_lat":"55.763928","geo_lon":"37.606379","beltway_hit":null,"beltway_distance":null,"metro":null,"divisions":null,"qc_geo":"2","qc_complete":null,"qc_house":null,"history_values":null,"unparsed_parts":null,"source":null,"qc":null}},{"value":"г Москва, ул 1-я Тверская-Ямская","unrestricted_value":"г Москва, Тверской р-н, ул 1-я Тверская-Ямская","data":{"postal_code":null,"country":"Россия","country_iso_code":"RU","federal_district":"Центральный","region_fias_id":"0c5b2444-70a0-4932-980c-b4dc0d3f02b5","region_kladr_id":"7700000000000","region_iso_code":"RU-MOW","region_with_type":"г Москва","region_type":"г","region_type_full":"город","region":"Москва","area_fias_id":null,"area_kladr_id":null,"area_with_type":null,"area_type":null,"area_type_full":null,"area":null,"city_fias_id":"0c5b2444-70a0-4932-980c-b4dc0d3f02b5","city_kladr_id":"7700000000000","city_with_type":"г Москва","city_type":"г","city_type_full":"город","city":"Москва","city_area":"Центральный","city_district_fias_id":null,"city_district_kladr_id":null,"city_district_with_type":null,"city_district_type":null,"city_district_type_full":null,"city_district":null,"settlement_fias_id":null,"settlement_kladr_id":null,"settlement_with_type":null,"settlement_type":null,"settlement_type_full":null,"settlement":null,"street_fias_id":"94d0cf51-2820-4409-bbd7-4a7d36f2922b","street_kladr_id":"77000000000287900","street_with_type":"ул 1-я Тверская-Ямская","street_type":"ул","street_type_full":"улица","street":"1-я Тверская-Ямская","stead_fias_id":null,"stead_cadnum":null,"stead_type":null,"stead_type_full":null,"stead":null,"house_fias_id":null,"house_kladr_id":null,"house_cadnum":null,"house_type":null,"house_type_full":null,"house":null,"block_type":null,"block_type_full":null,"block":null,"entrance":null,"floor":null,"flat_fias_id":null,"flat_cadnum":null,"flat_type":null,"flat_type_full":null,"flat":null,"flat_area":null,"square_meter_price":null,"flat_price":null,"room_fias_id":null,"room_cadnum":null,"room_type":null,"room_type_full":null,"room":null,"postal_box":null,"fias_id":"94d0cf51-2820-4409-bbd7-4a7d36f2922b","fias_code":null,"fias_level":"7","fias_actuality_state":"0","kladr_id":"77000000000287900","geoname_id":"524901","capital_marker":"0","okato":"45286585000","oktmo":"45382000","tax_office":"7710","tax_office_legal":"7710","timezone":null,"geo_lat":"55.773596","geo_lon":"37.589761","beltway_hit":null,"beltway_distance":null,"metro":null,"divisions":null,"qc_geo":"2","qc_complete":null,"qc_house":null,"history_values":null,"unparsed_parts":null,"source":null,"qc":null}},{"value":"г Москва, ул 2-я Тверская-Ямская","unrestricted_value":"125047, г Москва, Тверской р-н, ул 2-я Тверская-Ямская","data":{"postal_code":"125047","country":"Россия","country_iso_code":"RU","federal_district":"Центральный","region_fias_id":"0c5b2444-70a0-4932-980c-b4dc0d3f02b5","region_kladr_id":"7700000000000","region_iso_code":"RU-MOW","region_with_type":"г Москва","region_type":"г","region_type_full":"город","region":"Москва","area_fias_id":null,"area_kladr_id":null,"area_with_type":null,"area_type":null,"area_type_full":null,"area":null,"city_fias_id":"0c5b2444-70a0-4932-980c-b4dc0d3f02b5","city_kladr_id":"7700000000000","city_with_type":"г Москва","city_type":"г","city_type_full":"город","city":"Москва","city_area":"Центральный","city_district_fias_id":null,"city_district_kladr_id":null,"city_district_with_type":null,"city_district_type":null,"city_district_type_full":null,"city_district":null,"settlement_fias_id":null,"settlement_kladr_id":null,"settlement_with_type":null,"settlement_type":null,"settlement_type_full":null,"settlement":null,"street_fias_id":"5ba0c536-b105-4c8b-8b9a-8b06a64a4073","street_kladr_id":"77000000000288000","street_with_type":"ул 2-я Тверская-Ямская","street_type":"ул","street_type_full":"улица","street":"2-я Тверская-Ямская","stead_fias_id":null,"stead_cadnum":null,"stead_type":null,"stead_type_full":null,"stead":null,"house_fias_id":null,"house_kladr_id":null,"house_cadnum":null,"house_type":null,"house_type_full":null,"house":null,"block_type":null,"block_type_full":null,"block":null,"entrance":null,"floor":null,"flat_fias_id":null,"flat_cadnum":null,"flat_type":null,"flat_type_full":null,"flat":null,"flat_area":null,"square_meter_price":null,"flat_price":null,"room_fias_id":null,"room_cadnum":null,"room_type":null,"room_type_full":null,"room":null,"postal_box":null,"fias_id":"5ba0c536-b105-4c8b-8b9a-8b06a64a4073","fias_code":null,"fias_level":"7","fias_actuality_state":"0","kladr_id":"77000000000288000","geoname_id":"524901","capital_marker":"0","okato":"45286585000","oktmo":"45382000","tax_office":"7710","tax_office_legal":"7710","timezone":null,"geo_lat":"55.774102","geo_lon":"37.590282","beltway_hit":null,"beltway_distance":null,"metro":null,"divisions":null,"qc_geo":"2","qc_complete":null,"qc_house":null,"history_values":null,"unparsed_parts":null,"source":null,"qc":null}},{"value":"г Москва, ул 3-я Тверская-Ямская","unrestricted_value":"125047, г Москва, Тверской р-н, ул 3-я Тверская-Ямская","data":{"postal_code":"125047","country":"Россия","country_iso_code":"RU","federal_district":"Центральный","region_fias_id":"0c5b2444-70a0-4932-980c-b4dc0d3f02b5","region_kladr_id":"7700000000000","region_iso_code":"RU-MOW","region_with_type":"г Москва","region_type":"г","region_type_full":"город","region":"Москва","area_fias_id":null,"area_kladr_id":null,"area_with_type":null,"area_type":null,"area_type_full":null,"area":null,"city_fias_id":"0c5b2444-70a0-4932-980c-b4dc0d3f02b5","city_kladr_id":"7700000000000","city_with_type":"г Москва","city_type":"г","city_type_full":"город","city":"Москва","city_area":"Центральный","city_district_fias_id":null,"city_district_kladr_id":null,"city_district_with_type":null,"city_district_type":null,"city_district_type_full":null,"city_district":null,"settlement_fias_id":null,"settlement_kladr_id":null,"settlement_with_type":null,"settlement_type":null,"settlement_type_full":null,"settlement":null,"street_fias_id":"1735120d-e814-4ca2-bf8d-5f53b42ea541","street_kladr_id":"77000000000288100","street_with_type":"ул 3-я Тверская-Ямская","street_type":"ул","street_type_full":"улица","street":"3-я Тверская-Ямская","stead_fias_id":null,"stead_cadnum":null,"stead_type":null,"stead_type_full":null,"stead":null,"house_fias_id":null,"house_kladr_id":null,"house_cadnum":null,"house_type":null,"house_type_full":null,"house":null,"block_type":null,"block_type_full":null,"block":null,"entrance":null,"floor":null,"flat_fias_id":null,"flat_cadnum":null,"flat_type":null,"flat_type_full":null,"flat":null,"flat_area":null,"square_meter_price":null,"flat_price":null,"room_fias_id":null,"room_cadnum":null,"room_type":null,"room_type_full":null,"room":null,"postal_box":null,"fias_id":"1735120d-e814-4ca2-bf8d-5f53b42ea541","fias_code":null,"fias_level":"7","fias_actuality_state":"0","kladr_id":"77000000000288100","geoname_id":"524901","capital_marker":"0","okato":"45286585000","oktmo":"45382000","tax_office":"7710","tax_office_legal":"7710","timezone":null,"geo_lat":"55.774148","geo_lon":"37.592168","beltway_hit":null,"beltway_distance":null,"metro":null,"divisions":null,"qc_geo":"2","qc_complete":null,"qc_house":null,"history_values":null,"unparsed_parts":null,"source":null,"qc":null}},{"value":"г Москва, ул 4-я Тверская-Ямская","unrestricted_value":"125047, г Москва, Тверской р-н, ул 4-я Тверская-Ямская","data":{"postal_code":"125047","country":"Россия","country_iso_code":"RU","federal_district":"Центральный","region_fias_id":"0c5b2444-70a0-4932-980c-b4dc0d3f02b5","region_kladr_id":"7700000000000","region_iso_code":"RU-MOW","region_with_type":"г Москва","region_type":"г","region_type_full":"город","region":"Москва","area_fias_id":null,"area_kladr_id":null,"area_with_type":null,"area_type":null,"area_type_full":null,"area":null,"city_fias_id":"0c5b2444-70a0-4932-980c-b4dc0d3f02b5","city_kladr_id":"7700000000000","city_with_type":"г Москва","city_type":"г","city_type_full":"город","city":"Москва","city_area":"Центральный","city_district_fias_id":null,"city_district_kladr_id":null,"city_district_with_type":null,"city_district_type":null,"city_district_type_full":null,"city_district":null,"settlement_fias_id":null,"settlement_kladr_id":null,"settlement_with_type":null,"settlement_type":null,"settlement_type_full":null,"settlement":null,"street_fias_id":"1b366b75-a6bb-4037-b5ab-ff8092dc3405","street_kladr_id":"77000000000288200","street_with_type":"ул 4-я Тверская-Ямская","street_type":"ул","street_type_full":"улица","street":"4-я Тверская-Ямская","stead_fias_id":null,"stead_cadnum":null,"stead_type":null,"stead_type_full":null,"stead":null,"house_fias_id":null,"house_kladr_id":null,"house_cadnum":null,"house_type":null,"house_type_full":null,"house":null,"block_type":null,"block_type_full":null,"block":null,"entrance":null,"floor":null,"flat_fias_id":null,"flat_cadnum":null,"flat_type":null,"flat_type_full":null,"flat":null,"flat_area":null,"square_meter_price":null,"flat_price":null,"room_fias_id":null,"room_cadnum":null,"room_type":null,"room_type_full":null,"room":null,"postal_box":null,"fias_id":"1b366b75-a6bb-4037-b5ab-ff8092dc3405","fias_code":null,"fias_level":"7","fias_actuality_state":"0","kladr_id":"77000000000288200","geoname_id":"524901","capital_marker":"0","okato":"45286585000","oktmo":"45382000","tax_office":"7710","tax_office_legal":"7710","timezone":null,"geo_lat":"55.773008","geo_lon":"37.596085","beltway_hit":null,"beltway_distance":null,"metro":null,"divisions":null,"qc_geo":"2","qc_complete":null,"qc_house":null,"history_values":null,"unparsed_parts":null,"source":null,"qc":null}},{"value":"г Москва, Тверская пл","unrestricted_value":"г Москва, Тверской р-н, Тверская пл","data":{"postal_code":null,"country":"Россия","country_iso_code":"RU","federal_district":"Центральный","region_fias_id":"0c5b2444-70a0-4932-980c-b4dc0d3f02b5","region_kladr_id":"7700000000000","region_iso_code":"RU-MOW","region_with_type":"г Москва","region_type":"г","region_type_full":"город","region":"Москва","area_fias_id":null,"area_kladr_id":null,"area_with_type":null,"area_type":null,"area_type_full":null,"area":null,"city_fias_id":"0c5b2444-70a0-4932-980c-b4dc0d3f02b5","city_kladr_id":"7700000000000","city_with_type":"г Москва","city_type":"г","city_type_full":"город","city":"Москва","city_area":"Центральный","city_district_fias_id":null,"city_district_kladr_id":null,"city_district_with_type":null,"city_district_type":null,"city_district_type_full":null,"city_district":null,"settlement_fias_id":null,"settlement_kladr_id":null,"settlement_with_type":null,"settlement_type":null,"settlement_type_full":null,"settlement":null,"street_fias_id":"8cad81a1-0e97-4801-8f24-56c7b56fecc0","street_kladr_id":"77000000000748800","street_with_type":"Тверская пл","street_type":"пл","street_type_full":"площадь","street":"Тверская","stead_fias_id":null,"stead_cadnum":null,"stead_type":null,"stead_type_full":null,"stead":null,"house_fias_id":null,"house_kladr_id":null,"house_cadnum":null,"house_type":null,"house_type_full":null,"house":null,"block_type":null,"block_type_full":null,"block":null,"entrance":null,"floor":null,"flat_fias_id":null,"flat_cadnum":null,"flat_type":null,"flat_type_full":null,"flat":null,"flat_area":null,"square_meter_price":null,"flat_price":null,"room_fias_id":null,"room_cadnum":null,"room_type":null,"room_type_full":null,"room":null,"postal_box":null,"fias_id":"8cad81a1-0e97-4801-8f24-56c7b56fecc0","fias_code":null,"fias_level":"7","fias_actuality_state":"0","kladr_id":"77000000000748800","geoname_id":"524901","capital_marker":"0","okato":"45286585000","oktmo":"45382000","tax_office":"7710","tax_office_legal":"7710","timezone":null,"geo_lat":"55.761811","geo_lon":"37.610107","beltway_hit":null,"beltway_distance":null,"metro":null,"divisions":null,"qc_geo":"2","qc_complete":null,"qc_house":null,"history_values":null,"unparsed_parts":null,"source":null,"qc":null}},{"value":"г Москва, Тверской проезд","unrestricted_value":"г Москва, Тверской р-н, Тверской проезд","data":{"postal_code":null,"country":"Россия","country_iso_code":"RU","federal_district":"Центральный","region_fias_id":"0c5b2444-70a0-4932-980c-b4dc0d3f02b5","region_kladr_id":"7700000000000","region_iso_code":"RU-MOW","region_with_type":"г Москва","region_type":"г","region_type_full":"город","region":"Москва","area_fias_id":null,"area_kladr_id":null,"area_with_type":null,"area_type":null,"area_type_full":null,"area":null,"city_fias_id":"0c5b2444-70a0-4932-980c-b4dc0d3f02b5","city_kladr_id":"7700000000000","city_with_type":"г Москва","city_type":"г","city_type_full":"город","city":"Москва","city_area":"Центральный","city_district_fias_id":null,"city_district_kladr_id":null,"city_district_with_type":null,"city_district_type":null,"city_district_type_full":null,"city_district":null,"settlement_fias_id":null,"settlement_kladr_id":null,"settlement_with_type":null,"settlement_type":null,"settlement_type_full":null,"settlement":null,"street_fias_id":"016862f5-f905-46b3-84d3-69539a402c90","street_kladr_id":"77000000000748900","street_with_type":"Тверской проезд","street_type":"проезд","street_type_full":"проезд","street":"Тверской","stead_fias_id":null,"stead_cadnum":null,"stead_type":null,"stead_type_full":null,"stead":null,"house_fias_id":null,"house_kladr_id":null,"house_cadnum":null,"house_type":null,"house_type_full":null,"house":null,"block_type":null,"block_type_full":null,"block":null,"entrance":null,"floor":null,"flat_fias_id":null,"flat_cadnum":null,"flat_type":null,"flat_type_full":null,"flat":null,"flat_area":null,"square_meter_price":null,"flat_price":null,"room_fias_id":null,"room_cadnum":null,"room_type":null,"room_type_full":null,"room":null,"postal_box":null,"fias_id":"016862f5-f905-46b3-84d3-69539a402c90","fias_code":null,"fias_level":"7","fias_actuality_state":"0","kladr_id":"77000000000748900","geoname_id":"524901","capital_marker":"0","okato":"45286585000","oktmo":"45382000","tax_office":"7710","tax_office_legal":"7710","timezone":null,"geo_lat":"55.762449","geo_lon":"37.611122","beltway_hit":null,"beltway_distance":null,"metro":null,"divisions":null,"qc_geo":"2","qc_complete":null,"qc_house":null,"history_values":null,"unparsed_parts":null,"source":null,"qc":null}},{"value":"г Москва, Тверской б-р","unrestricted_value":"г Москва, Тверской б-р","data":{"postal_code":null,"country":"Россия","country_iso_code":"RU","federal_district":"Центральный","region_fias_id":"0c5b2444-70a0-4932-980c-b4dc0d3f02b5","region_kladr_id":"7700000000000","region_iso_code":"RU-MOW","region_with_type":"г Москва","region_type":"г","region_type_full":"город","region":"Москва","area_fias_id":null,"area_kladr_id":null,"area_with_type":null,"area_type":null,"area_type_full":null,"area":null,"city_fias_id":"0c5b2444-70a0-4932-980c-b4dc0d3f02b5","city_kladr_id":"7700000000000","city_with_type":"г Москва","city_type":"г","city_type_full":"город","city":"Москва","city_area":"Центральный","city_district_fias_id":null,"city_district_kladr_id":null,"city_district_with_type":null,"city_district_type":null,"city_district_type_full":null,"city_district":null,"settlement_fias_id":null,"settlement_kladr_id":null,"settlement_with_type":null,"settlement_type":null,"settlement_type_full":null,"settlement":null,"street_fias_id":"2604e353-b9dd-4542-a8bf-020c8f982797","street_kladr_id":"77000000000288300","street_with_type":"Тверской б-р","street_type":"б-р","street_type_full":"бульвар","street":"Тверской","stead_fias_id":null,"stead_cadnum":null,"stead_type":null,"stead_type_full":null,"stead":null,"house_fias_id":null,"house_kladr_id":null,"house_cadnum":null,"house_type":null,"house_type_full":null,"house":null,"block_type":null,"block_type_full":null,"block":null,"entrance":null,"floor":null,"flat_fias_id":null,"flat_cadnum":null,"flat_type":null,"flat_type_full":null,"flat":null,"flat_area":null,"square_meter_price":null,"flat_price":null,"room_fias_id":null,"room_cadnum":null,"room_type":null,"room_type_full":null,"room":null,"postal_box":null,"fias_id":"2604e353-b9dd-4542-a8bf-020c8f982797","fias_code":null,"fias_level":"7","fias_actuality_state":"0","kladr_id":"77000000000288300","geoname_id":"524901","capital_marker":"0","okato":"45000000000","oktmo":"45000000","tax_office":"7700","tax_office_legal":"7700","timezone":null,"geo_lat":"55.760945","geo_lon":"37.601978","beltway_hit":null,"beltway_distance":null,"metro":null,"divisions":null,"qc_geo":"2","qc_complete":null,"qc_house":null,"history_values":null,"unparsed_parts":null,"source":null,"qc":null}},{"value":"г Москва, пл Тверская Застава","unrestricted_value":"125047, г Москва, Тверской р-н, пл Тверская Застава","data":{"postal_code":"125047","country":"Россия","country_iso_code":"RU","federal_district":"Центральный","region_fias_id":"0c5b2444-70a0-4932-980c-b4dc0d3f02b5","region_kladr_id":"7700000000000","region_iso_code":"RU-MOW","region_with_type":"г Москва","region_type":"г","region_type_full":"город","region":"Москва","area_fias_id":null,"area_kladr_id":null,"area_with_type":null,"area_type":null,"area_type_full":null,"area":null,"city_fias_id":"0c5b2444-70a0-4932-980c-b4dc0d3f02b5","city_kladr_id":"7700000000000","city_with_type":"г Москва","city_type":"г","city_type_full":"город","city":"Москва","city_area":"Центральный","city_district_fias_id":null,"city_district_kladr_id":null,"city_district_with_type":null,"city_district_type":null,"city_district_type_full":null,"city_district":null,"settlement_fias_id":null,"settlement_kladr_id":null,"settlement_with_type":null,"settlement_type":null,"settlement_type_full":null,"settlement":null,"street_fias_id":"3f28b35f-caab-4715-94cd-9f652a441690","street_kladr_id":"77000000000711300","street_with_type":"пл Тверская Застава","street_type":"пл","street_type_full":"площадь","street":"Тверская Застава","stead_fias_id":null,"stead_cadnum":null,"stead_type":null,"stead_type_full":null,"stead":null,"house_fias_id":null,"house_kladr_id":null,"house_cadnum":null,"house_type":null,"house_type_full":null,"house":null,"block_type":null,"block_type_full":null,"block":null,"entrance":null,"floor":null,"flat_fias_id":null,"flat_cadnum":null,"flat_type":null,"flat_type_full":null,"flat":null,"flat_area":null,"square_meter_price":null,"flat_price":null,"room_fias_id":null,"room_cadnum":null,"room_type":null,"room_type_full":null,"room":null,"postal_box":null,"fias_id":"3f28b35f-caab-4715-94cd-9f652a441690","fias_code":null,"fias_level":"7","fias_actuality_state":"0","kladr_id":"77000000000711300","geoname_id":"524901","capital_marker":"0","okato":"45286585000","oktmo":"45382000","tax_office":"7710","tax_office_legal":"7710","timezone":null,"geo_lat":"55.776532","geo_lon":"37.583616","beltway_hit":null,"beltway_distance":null,"metro":null,"divisions":null,"qc_geo":"2","qc_complete":null,"qc_house":null,"history_values":["пл Белорусского Вокзала"],"unparsed_parts":null,"source":null,"qc":null}},{"value":"г Москва, 1-й Тверской-Ямской пер","unrestricted_value":"125047, г Москва, Тверской р-н, 1-й Тверской-Ямской пер","data":{"postal_code":"125047","country":"Россия","country_iso_code":"RU","federal_district":"Центральный","region_fias_id":"0c5b2444-70a0-4932-980c-b4dc0d3f02b5","region_kladr_id":"7700000000000","region_iso_code":"RU-MOW","region_with_type":"г Москва","region_type":"г","region_type_full":"город","region":"Москва","area_fias_id":null,"area_kladr_id":null,"area_with_type":null,"area_type":null,"area_type_full":null,"area":null,"city_fias_id":"0c5b2444-70a0-4932-980c-b4dc0d3f02b5","city_kladr_id":"7700000000000","city_with_type":"г Москва","city_type":"г","city_type_full":"город","city":"Москва","city_area":"Центральный","city_district_fias_id":null,"city_district_kladr_id":null,"city_district_with_type":null,"city_district_type":null,"city_district_type_full":null,"city_district":null,"settlement_fias_id":null,"settlement_kladr_id":null,"settlement_with_type":null,"settlement_type":null,"settlement_type_full":null,"settlement":null,"street_fias_id":"4f790518-2284-459f-8c69-da6eebb2e4dc","street_kladr_id":"77000000000288400","street_with_type":"1-й Тверской-Ямской пер","street_type":"пер","street_type_full":"переулок","street":"1-й Тверской-Ямской","stead_fias_id":null,"stead_cadnum":null,"stead_type":null,"stead_type_full":null,"stead":null,"house_fias_id":null,"house_kladr_id":null,"house_cadnum":null,"house_type":null,"house_type_full":null,"house":null,"block_type":null,"block_type_full":null,"block":null,"entrance":null,"floor":null,"flat_fias_id":null,"flat_cadnum":null,"flat_type":null,"flat_type_full":null,"flat":null,"flat_area":null,"square_meter_price":null,"flat_price":null,"room_fias_id":null,"room_cadnum":null,"room_type":null,"room_type_full":null,"room":null,"postal_box":null,"fias_id":"4f790518-2284-459f-8c69-da6eebb2e4dc","fias_code":null,"fias_level":"7","fias_actuality_state":"0","kladr_id":"77000000000288400","geoname_id":"524901","capital_marker":"0","okato":"45286585000","oktmo":"45382000","tax_office":"7710","tax_office_legal":"7710","timezone":null,"geo_lat":"55.772669","geo_lon":"37.596857","beltway_hit":null,"beltway_distance":null,"metro":null,"divisions":null,"qc_geo":"2","qc_complete":null,"qc_house":null,"history_values":null,"unparsed_parts":null,"source":null,"qc":null}}]}
//array.map((arr) => console.log(arr));

//console.log(puls.value)
//const parsedData = JSON.parse(data);
//console.log(parsedData.users[1].value); // => Bob
 // for(const user of puls) {
 //     console.log(number);
 // }





