jQuery(function($) {
    var data = $.extend({}, montageFormConfig['fields'], {
        // showProducts: false,
        // searchProduct: '97901-3',
        products: montageFormConfig['products'],
        // productSelected: [],
        // productSelectedIds: [],
        required: {},
        allFilled: false
    });

    function initDropzone($node) {
        $node.each(function () {
            var $area = $(this);
            var labelId = $area.attr('for');
            var $file = $('#' + labelId);
            $file.show();

            if ($file.prop('multiple')) {
                var $label = $file.closest('label');
                var $clone = $file.clone().attr('id', '');
                $label.on('change', '.dropzone-multiple-file', function(){
                    var $this = $(this);
                    var haveFile = !!$this.val();
                    if (haveFile && !$this.next('.dropzone-multiple-file').length) {
                        $clone.clone().appendTo($label);
                    }
                });
            }

            $area.addClass('dropzone');
            $area.find('.input-hint')
                .addClass('dz-default dz-message')
                .removeClass('input-hint');
        })
    }

    window.initDropzone = initDropzone;

    // $(montageFormConfig).each(function(a,b){
    //     debugger;
    // });
    BX.Vue.create({
        el: $('.montage-form')[0],
        data: data,
        // created: function(){},
        mounted: function(){
            // $(this.$el).find('input, textarea, select').filter('[data-id]').each(function () {
            //     var $this = $(this);
            //     var id = $this.data('id');
            //     var type = 'text';
            //     if ($this.is('textarea')) {
            //         type = 'textarea';
            //     }
            //     if ($this.is(':radio')) {
            //         type = 'radio';
            //     }
            //     if ($this.is(':checkbox')) {
            //         type = 'checkbox';
            //     }
            //     if ($this.is(':file')) {
            //         type = 'file';
            //     }
            //     if (!inputs[id]) {
            //         inputs[id] = {
            //             type: type,
            //             nodes: [],
            //         }
            //     }
            //     inputs[id].nodes.append($this);
            // });
            var self = this;
            if (this.searchProduct) {
                this.showProducts = true;
                this.search(this.searchProduct);
            }
            $(this.$el).find("#montage_PHONE").inputmask('mask', {'mask':'+7 (999) 999-99-99'});
            $(this.$el).find("#montage_PASSPORT_SERIES").inputmask('mask', {'mask':'99-99'});
            $(this.$el).find("#montage_PASSPORT_NUMBER").inputmask('mask', {'mask':'999-999'});
            $(this.$el).find("#montage_PASSPORT_BIRTHDAY").inputmask('mask', {'mask':'99.99.9999'});
            $(this.$el).find("#montage_PASSPORT_WHEN_ISSUED").inputmask('mask', {'mask':'99.99.9999'});

            function updateRequiredValue() {
                var $this = $(this);
                // var name = $this.attr('name');
                var val = !!$this.val();
                var newDiff = {};
                newDiff[this] = val;
                self.required = $.extend({}, self.required, newDiff);
            }

            initDropzone($(this.$el).find('.dropzone-area'));

            $(this.$el).find("[required]")
                .each(updateRequiredValue)
                .on('input change', updateRequiredValue);

            if (montageFormConfig['watchSelect']) {
                $.each(montageFormConfig['watchSelect'], function(i, val){
                    $(self.$el).on('change input', '#' + val, function(e) {
                        self[i] = $(this).val();
                    });
                });
            }
        },
        watch: {
            searchProduct: function(newValue, oldValue) {
                this.showProducts = true;
                if (newValue) {
                    this.search(newValue);
                }
                else {
                    this.products = [];
                }
            },
            required: function (newValue, oldValue) {
                var all = 0;
                var count = 0;
                $.each(newValue, function (name, value) {
                    all += 1;
                    count += value ? 1 : 0;
                });
                this.allFilled = all == count;
            }
        },
        computed: {
            ADDRSSS_SPECIALIST_VISIT_PRICE: function () {
                if (this.NEED_SPECIALIST_VISIT == 273) {
                    return 0;
                }
                if (this.ADDRESS_ZONE == 125) { // зона D
                    var mkad = parseFloat(this.ADDRESS_DISTANCE_MKAD.replace(/[,]/, '.')) || 0;
                    return montageFormConfig['visitPrice'] + mkad * montageFormConfig['visitRangePrice'];
                }
                if (this.ADDRESS_ZONE == 126) { // зона Другое
                    return 'Цена договорная'
                }
                return montageFormConfig['visitPrice'];
            },
            PRODUCTS: function () {
                if (!this.products.length) {
                    return '';
                }
                var self = this;
                var text = '';
                $.each(this.products, function(i, product) {
                    if (product.quantity*1) {
                        text += product.name 
                            + ', ' + product.price.raw + ' руб.'
                            + ' кол-во: ' + product.quantity + ' п/м.'
                            // + ', итого ' + self.getProductSum(product) + ' руб.'
                            + ', монтаж ' + self.getProductMontage(product) + ' руб.'
                            + '\n';
                    }
                });
                return text;
            },
            ESTIMATED_COST_MONTAGE: function () {
                if (!this.products.length) {
                    return 0;
                }
                var self = this;
                var sum = 0;
                $.each(this.products, function (i, product) {
                    if (product.quantity * 1) {
                        sum += 1*self.getProductMontage(product);
                    }
                });
                return sum;
            },
            // after18Price: function () {
            //     if (this.SERVICE_INSTALLATION_WORK_AFTER_18 == montageFormConfig['after18HourId']) {
            //         var price = this.ESTIMATED_COST_MONTAGE * montageFormConfig['after18HourRatio'];
            //         price = this.roundIntPrice(price);
            //         return price;
            //     }
            //     return 0;
            // },
            // after3HeightPrice: function () {
            //     if (this.SERVICE_INSTALLATION_HEIGHT__OVER_3M == montageFormConfig['after3HeightId']) {
            //         var price = this.ESTIMATED_COST_MONTAGE * montageFormConfig['after3HeightRatio'];
            //         price = this.roundIntPrice(price);
            //         return Math.max(price, montageFormConfig['after3HeightMinPrice']);
            //     }
            //     return 0;
            // },
            ESTIMATED_COST_SERVICES: function () {
                var ADDRSSS_SPECIALIST_VISIT_PRICE = parseInt(this.ADDRSSS_SPECIALIST_VISIT_PRICE) || 0;
                var price = ADDRSSS_SPECIALIST_VISIT_PRICE + this.ESTIMATED_COST_MONTAGE ;
                
                // var minPrice = montageFormConfig.costMinPrices[this.OBJECT_AREA];
                // minPrice = minPrice || 0;
                // return Math.max(price, minPrice);
                return price;
            },
        },
        methods: {
            roundIntPrice: function (price) {
                var newPrice = Math.floor(price);
                if ((price - newPrice) > 0) {
                    newPrice = newPrice + 1;
                }
                return newPrice;
            },
            // search: function(text) {
            //     var self = this;
            //     $.ajax({
            //         method: 'post',
            //         url: 'search.php',
            //         data: {
            //             'q': text
            //         },
            //         success: function (data) {
            //             if (data && data.PRODUCTS && data.PRODUCTS.length) {
            //                 self.products = data.PRODUCTS;
            //             }
            //             else {
            //                 self.products = [];
            //             }
            //         }
            //     });
            // },
            // selectProduct: function (product) {
            //     if (this.productSelectedIds.indexOf(product.id) === -1) {
            //         var newProduct = $.extend({}, product);
            //         newProduct.quantity = 1;
            //         this.productSelected.push(newProduct);
            //         this.productSelectedIds.push(newProduct.id);
            //     }
            // },
            // unselectProduct: function (product) {
            //     this.productSelectedIds.splice(this.productSelectedIds.indexOf(product.id), 1)
            //     this.productSelected.splice(this.productSelected.indexOf(product), 1)
            // },
            // getProductSum: function (product) {
            //     return product.price.raw * product.quantity;
            // },
            getProductMontage: function (product) {
                // var ratio = this.getProductMontageRatio(product);
                var ratio = 1;
                var quantity = 1 * parseInt(product.quantity);
                if (!quantity) {
                    quantity = 0;
                }
                return this.roundIntPrice(product.price.raw * quantity * ratio);
            },
            openPreview: function () {
                var params = $(this.$el).find('form').serialize()
                window.open('?preview&' + params);
            }
            // getProductMontageRatio: function (product) {
            //     var puProducts = montageFormConfig['sectionsPuProducts'];
            //     var inPu = product.sectionIds.filter(function (value) {
            //         return -1 !== puProducts.indexOf(value);
            //     });
            //     if (inPu.length) {
            //         return montageFormConfig['sectionsPuProductsRatio'];
            //     }

            //     var montainable = montageFormConfig['sectionsMontainable'];
            //     var inMont = product.sectionIds.filter(function (value) {
            //         return -1 !== montainable.indexOf(value);
            //     });
            //     if (inMont.length) {
            //         return montageFormConfig['sectionsMontainableRatio'];
            //     }

            //     var nonep = montageFormConfig['sectionsNoneProducts'];
            //     var inNonep = product.sectionIds.filter(function (value) {
            //         return -1 !== nonep.indexOf(value);
            //     });
            //     if (inNonep.length) {
            //         return montageFormConfig['sectionsNoneProductsRatio'];
            //     }

            //     return montageFormConfig['sectionsDefaultRatio'];
            // },
        }
    })
    // var config = window.montageFormConfig
    // var $form = $('.montage-form');
    // var inputs = {};

    
    // var state = {};

    // function reinitState() {
    //     $.each()
    //     console.log($inputs);
    //     $inputs = $inputs
    //     console.log($inputs);

    //     applyState();
    // }

    // function applyState() {

    // }
    
    // console.log('initMontageForm', config);
    // console.log('initMontageForm', inputs);
    // reinitState();
});