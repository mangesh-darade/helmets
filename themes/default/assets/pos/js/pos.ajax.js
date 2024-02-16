$(document).ready(function () {
    $('.date').datetimepicker({format: site.dateFormats.js_sdate, fontAwesome: true, language: 'sma', todayBtn: 1, autoclose: 1, minView: 2});
    $(document).on('focus', '.date', function (t) {
        $(this).datetimepicker({format: site.dateFormats.js_sdate, fontAwesome: true, todayBtn: 1, autoclose: 1, minView: 2});
    });

    $('body a, body button').attr('tabindex', -1);
    check_add_item_val();
    $(document).on('keypress', '.rquantity', function (e) {
        if (e.keyCode == 13) {
            $('#add_item').focus();
        }
    });
    $('#toogle-customer-read-attr').click(function () {
        var nst = $('#poscustomer').is('[readonly]') ? false : true;
        $('#poscustomer').select2("readonly", nst);
        return false;
    });
    $(".open-brands").click(function () {
        $('#brands-slider').toggle('slide', {direction: 'right'}, 700);
    });
    $(".open-category").click(function () {
        $('#category-slider').toggle('slide', {direction: 'right'}, 700);
    });
    $(".open-subcategory").click(function () {
        $('#subcategory-slider').toggle('slide', {direction: 'right'}, 700);
    });
    $(document).on('click', function (e) {
        if (!$(e.target).is(".open-brands, .cat-child") && !$(e.target).parents("#brands-slider").size() && $('#brands-slider').is(':visible')) {
            $('#brands-slider').toggle('slide', {direction: 'right'}, 700);
        }
        if (!$(e.target).is(".open-category, .cat-child") && !$(e.target).parents("#category-slider").size() && $('#category-slider').is(':visible')) {
            $('#category-slider').toggle('slide', {direction: 'right'}, 700);
        }
        if (!$(e.target).is(".open-subcategory, .cat-child") && !$(e.target).parents("#subcategory-slider").size() && $('#subcategory-slider').is(':visible')) {
            $('#subcategory-slider').toggle('slide', {direction: 'right'}, 700);
        }
    });
    $('.po').popover({html: true, placement: 'right', trigger: 'click'}).popover();
    $('#inlineCalc').calculator({layout: ['_%+-CABS', '_7_8_9_/', '_4_5_6_*', '_1_2_3_-', '_0_._=_+'], showFormula: true});
    $('.calc').click(function (e) {
        e.stopPropagation();
    });
    $(document).on('click', '[data-toggle="ajax"]', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        $.get(href, function (data) {
            $("#myModal").html(data).modal();
        });
    });
    $(document).on('click', '.sname', function (e) {
        var row = $(this).closest('tr');
        var itemid = row.find('.rid').val();
        $('#myModal').modal({remote: site.base_url + 'products/modal_view/' + itemid});
        $('#myModal').modal('show');
    });
});
$(document).ready(function () {
// Order level shipping and discoutn localStorage
    if (posdiscount = localStorage.getItem('posdiscount')) {
        $('#posdiscount').val(posdiscount);
    }
    $(document).on('change', '#ppostax2', function () {
        localStorage.setItem('postax2', $(this).val());
        $('#postax2').val($(this).val());
    });

    if (postax2 = localStorage.getItem('postax2')) {
        $('#postax2').val(postax2);
    }

    $(document).on('blur', '#sale_note', function () {
        localStorage.setItem('posnote', $(this).val());
        $('#sale_note').val($(this).val());
    });

    if (posnote = localStorage.getItem('posnote')) {
        $('#sale_note').val(posnote);
    }

    $(document).on('blur', '#staffnote', function () {
        localStorage.setItem('staffnote', $(this).val());
        $('#staffnote').val($(this).val());
    });

    if (staffnote = localStorage.getItem('staffnote')) {
        $('#staffnote').val(staffnote);
    }

    /* ----------------------
     * Order Discount Handler
     * ---------------------- */
    $("#ppdiscount").click(function (e) {
        e.preventDefault();
        var dval = $('#posdiscount').val() ? $('#posdiscount').val() : '0';
        $('#order_discount_input').val(dval);
        $('#dsModal').modal();
    });
    $('#dsModal').on('shown.bs.modal', function () {
        $(this).find('#order_discount_input').select().focus();
        $('#order_discount_input').bind('keypress', function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                var ds = $('#order_discount_input').val();
                if (is_valid_discount(ds)) {
                    $('#posdiscount').val(ds);
                    localStorage.removeItem('posdiscount');
                    localStorage.setItem('posdiscount', ds);
                    loadItems();
                } else {
                    bootbox.alert(lang.unexpected_value);
                }
                $('#dsModal').modal('hide');
            }
        });
    });
    $(document).on('click', '#updateOrderDiscount', function () {
        var ds = $('#order_discount_input').val() ? $('#order_discount_input').val() : '0';
        if (is_valid_discount(ds)) {
            $('#posdiscount').val(ds);
            localStorage.removeItem('posdiscount');
            localStorage.setItem('posdiscount', ds);
            loadItems();
        } else {
            bootbox.alert(lang.unexpected_value);
        }
        $('#dsModal').modal('hide');
    });
    /* ----------------------
     * Order Tax Handler
     * ---------------------- */
    $("#pptax2").click(function (e) {
        e.preventDefault();
        var postax2 = localStorage.getItem('postax2');
        $('#order_tax_input').select2('val', postax2);
        $('#txModal').modal();
    });
    $('#txModal').on('shown.bs.modal', function () {
        $(this).find('#order_tax_input').select2('focus');
    });
    $('#txModal').on('hidden.bs.modal', function () {
        var ts = $('#order_tax_input').val();
        $('#postax2').val(ts);
        localStorage.setItem('postax2', ts);
        loadItems();
    });
    $(document).on('click', '#updateOrderTax', function () {
        var ts = $('#order_tax_input').val();
        $('#postax2').val(ts);
        localStorage.setItem('postax2', ts);
        loadItems();
        $('#txModal').modal('hide');
    });

    $(document).on('change', '.rserial', function() {
        positems='';
        var item_id = $(this).closest('tr').attr('data-item-id');
        positems[item_id].row.serial = $(this).val();
        localStorage.setItem('positems', JSON.stringify(positems));
    });

    //If there is any item in localStorage
    if(localStorage.getItem('positems')) {
        loadItems();
    }

    // clear localStorage and reload
    $('#reset').click(function (e) {
        bootbox.confirm(lang.r_u_sure, function (result) {
            if (result) {
                if (localStorage.getItem('positems')) {
                    localStorage.removeItem('positems');
                }
                if (localStorage.getItem('active_offers')) {
                    localStorage.removeItem('active_offers');
                }
                if (localStorage.getItem('applyOffers')) {
                    localStorage.removeItem('applyOffers');
                }
                if (localStorage.getItem('posdiscount')) {
                    localStorage.removeItem('posdiscount');
                }
                if (localStorage.getItem('postax2')) {
                    localStorage.removeItem('postax2');
                }
                if (localStorage.getItem('posshipping')) {
                    localStorage.removeItem('posshipping');
                }
                if (localStorage.getItem('posref')) {
                    localStorage.removeItem('posref');
                }
                if (localStorage.getItem('poswarehouse')) {
                    localStorage.removeItem('poswarehouse');
                }
                if (localStorage.getItem('posnote')) {
                    localStorage.removeItem('posnote');
                }
                if (localStorage.getItem('posinnote')) {
                    localStorage.removeItem('posinnote');
                }
                if (localStorage.getItem('poscustomer')) {
                    localStorage.removeItem('poscustomer');
                }
                if (localStorage.getItem('poscurrency')) {
                    localStorage.removeItem('poscurrency');
                }
                if (localStorage.getItem('posdate')) {
                    localStorage.removeItem('posdate');
                }
                if (localStorage.getItem('posstatus')) {
                    localStorage.removeItem('posstatus');
                }
                if (localStorage.getItem('posbiller')) {
                    localStorage.removeItem('posbiller');
                }

                $('#modal-loading').show();
                //location.reload();
                window.location.href = site.base_url + "pos";
            }
        });
    });

// save and load the fields in and/or from localStorage

    $('#poswarehouse').change(function (e) {
        localStorage.setItem('poswarehouse', $(this).val());
    });
    if (poswarehouse = localStorage.getItem('poswarehouse')) {
        $('#poswarehouse').select2('val', poswarehouse);
    }

    //$(document).on('change', '#posnote', function (e) {
    $('#posnote').redactor('destroy');
    $('#posnote').redactor({
        buttons: ['formatting', '|', 'alignleft', 'aligncenter', 'alignright', 'justify', '|', 'bold', 'italic', 'underline', '|', 'unorderedlist', 'orderedlist', '|', 'link', '|', 'html'],
        formattingTags: ['p', 'pre', 'h3', 'h4'],
        minHeight: 100,
        changeCallback: function (e) {
            var v = this.get();
            localStorage.setItem('posnote', v);
        }
    });
    if (posnote = localStorage.getItem('posnote')) {
        $('#posnote').redactor('set', posnote);
    }

    $('#poscustomer').change(function (e) {
        localStorage.setItem('poscustomer', $(this).val());
    });

// prevent default action upon enter
    $('body').not('textarea').bind('keypress', function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });

// Order tax calculation
    if (site.settings.tax2 != 0) {
        $('#postax2').change(function () {
            localStorage.setItem('postax2', $(this).val());
            loadItems();
            return;
        });
    }

// Order discount calculation
    var old_posdiscount;
    $('#posdiscount').focus(function () {
        old_posdiscount = $(this).val();
    }).change(function () {
        var new_discount = $(this).val() ? $(this).val() : '0';
        if (is_valid_discount(new_discount)) {
            localStorage.removeItem('posdiscount');
            localStorage.setItem('posdiscount', new_discount);
            loadItems();
            return;
        } else {
            $(this).val(old_posdiscount);
            bootbox.alert(lang.unexpected_value);
            return;
        }

    });

    /* ----------------------
     * Delete Row Method
     * ---------------------- */
    var pwacc = false;
    $(document).on('click', '.posdel', function () {
        var row = $(this).closest('tr');
        var item_id = row.attr('data-item-id');
        if (protect_delete == 1) {
            var boxd = bootbox.dialog({
                title: "<i class='fa fa-key'></i> Pin Code",
                message: '<input id="pos_pin" name="pos_pin" type="password" placeholder="Pin Code" class="form-control"> ',
                buttons: {
                    success: {
                        label: "<i class='fa fa-tick'></i> OK",
                        className: "btn-success verify_pin",
                        callback: function () {
                            var pos_pin = md5($('#pos_pin').val());
                            if (pos_pin == pos_settings.pin_code) {
                                delete positems[item_id];
                                row.remove();
                                if (positems.hasOwnProperty(item_id)) {
                                } else {
                                    localStorage.setItem('positems', JSON.stringify(positems));
                                    loadItems();
                                }
                            } else {
                                bootbox.alert('Wrong Pin Code');
                            }
                        }
                    }
                }
            });
            boxd.on("shown.bs.modal", function () {
                $("#pos_pin").focus().keypress(function (e) {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        $('.verify_pin').trigger('click');
                        return false;
                    }
                });
            });
        } else {
            //console.log(positems);
            //console.log(item_id);
            delete positems[item_id];
            //console.log(positems);
            row.remove();
            if (positems.hasOwnProperty(item_id)) {
            } else {
                resetCartItems();
                localStorage.setItem('positems', JSON.stringify(positems));
                loadItems();
            }
        }
        return false;
    });

    /* -----------------------
     * Edit Row Modal Hanlder
     ----------------------- */
    $(document).on('click', '.edit', function () {
        var row = $(this).closest('tr');
        var row_id = row.attr('id');
        item_id = row.attr('data-item-id');
        item = positems[item_id];
        var qty = row.children().children('.rquantity').val(),
                product_option = row.children().children('.roption').val(),
                unit_price = formatDecimal(row.children().children('.ruprice').val()),
                discount = row.children().children('.rdiscount').val();
                var description = row.children().children('.rdescription').val();
                var manualedit = (item.row.manualedit)?item.row.manualedit:'';  
        if (item.options !== false) {
            $.each(item.options, function () {
                if (this.id == item.row.option && this.price != 0 && this.price != '' && this.price != null) {
                   if(manualedit==''){ 
                     unit_price = parseFloat(item.row.real_unit_price) + parseFloat(this.price);
                   }  
                }
            });
        }
        var real_unit_price = item.row.real_unit_price;
        var net_price = unit_price;
        $('#prModalLabel').text(item.row.name + ' (' + item.row.code + ')');
        if (site.settings.tax1) {
            $('#ptax').select2('val', item.row.tax_rate);
            $('#old_tax').val(item.row.tax_rate);
            var item_discount = 0, ds = discount ? discount : '0';
            if (ds.indexOf("%") !== -1) {
                var pds = ds.split("%");
                if (!isNaN(pds[0])) {
                    item_discount = formatDecimal(parseFloat(((unit_price) * parseFloat(pds[0])) / 100), 4);
                } else {
                    item_discount = parseFloat(ds);
                }
            } else {
                item_discount = parseFloat(ds);
            }
            net_price -= item_discount;
            var pr_tax = item.row.tax_rate, pr_tax_val = 0;
            if (pr_tax !== null && pr_tax != 0) {
                $.each(tax_rates, function () {
                    if (this.id == pr_tax) {
                        if (this.type == 1) {
                            if (positems[item_id].row.tax_method == 0) {
                                pr_tax_val = formatDecimal((((net_price) * parseFloat(this.rate)) / (100 + parseFloat(this.rate))), 4);
                                pr_tax_rate = formatDecimal(this.rate) + '%';
                                net_price -= pr_tax_val;
                            } else {
                                pr_tax_val = formatDecimal((((net_price) * parseFloat(this.rate)) / 100), 4);
                                pr_tax_rate = formatDecimal(this.rate) + '%';
                            }
                        } else if (this.type == 2) {

                            pr_tax_val = parseFloat(this.rate);
                            pr_tax_rate = this.rate;

                        }
                    }
                });
            }
        }
        if (site.settings.product_serial !== 0) {
            $('#pserial').val(row.children().children('.rserial').val());
        }
        var opt = '<p style="margin: 12px 0 0 0;">n/a</p>';
        if (item.options !== false) {
            var o = 1;
            opt = $("<select id=\"poption\" name=\"poption\" class=\"form-control select\" />");
            $.each(item.options, function () {
                if (o == 1) {
                    if (product_option == '') {
                        product_variant = this.id;
                    } else {
                        product_variant = product_option;
                    }
                }
                $("<option />", {value: this.id, text: this.name}).appendTo(opt);
                o++;
            });
        } else {
            product_variant = 0;
        }
        if (item.units !== false) {
            uopt = $("<select id=\"punit\" name=\"punit\" class=\"form-control \" />"); //select
            $.each(item.units, function () {
                if (this.id == item.row.unit) {
                    $("<option />", {value: this.id, text: this.name, selected: true}).appendTo(uopt);
                } else {
                    $("<option />", {value: this.id, text: this.name}).appendTo(uopt);
                }
            });
        } else {
            uopt = '<p style="margin: 12px 0 0 0;">n/a</p>';
        }

        $('#poptions-div').html(opt);
        $('#punits-div').html(uopt);
        $('select.select').select2({minimumResultsForSearch: 7});
        $('#pquantity').val(qty);
        $('#old_qty').val(qty);
        $('#pprice').val(unit_price);
        $('#punit_price').val(formatDecimal(parseFloat(unit_price) + parseFloat(pr_tax_val)));
        $('#poption').select2('val', item.row.option);
        $('#old_price').val(unit_price);
        $('#row_id').val(row_id);
        $('#item_id').val(item_id);
        $('#pserial').val(row.children().children('.rserial').val());
        $('#pdiscount').val(discount);
        $('#pdescription').val(description);
        $('#net_price').text(formatMoney(net_price));
        $('#pro_tax').text(formatMoney(pr_tax_val));
        $('#prModal').appendTo("body").modal('show');

    });

    $('#prModal').on('shown.bs.modal', function (e) {
        if ($('#poption').select2('val') != '') {
            $('#poption').select2('val', product_variant);
            product_variant = 0;
        }
    });

    $(document).on('change', '#pprice, #ptax, #pdiscount', function () {
        var row = $('#' + $('#row_id').val());
        var item_id = row.attr('data-item-id');
        var unit_price = parseFloat($('#pprice').val());
        var item = positems[item_id];
        var ds = $('#pdiscount').val() ? $('#pdiscount').val() : '0';
        if (ds.indexOf("%") !== -1) {
            var pds = ds.split("%");
            if (!isNaN(pds[0])) {
                item_discount = parseFloat(((unit_price) * parseFloat(pds[0])) / 100);
            } else {
                item_discount = parseFloat(ds);
            }
        } else {
            item_discount = parseFloat(ds);
        }
        unit_price -= item_discount;
        var pr_tax = $('#ptax').val(), item_tax_method = item.row.tax_method;
        var pr_tax_val = 0, pr_tax_rate = 0;
        if (pr_tax !== null && pr_tax != 0) {
            $.each(tax_rates, function () {
                if (this.id == pr_tax) {
                    if (this.type == 1) {
                        if (item_tax_method == 0) {
                            pr_tax_val = formatDecimal(((unit_price) * parseFloat(this.rate)) / (100 + parseFloat(this.rate)));
                            pr_tax_rate = formatDecimal(this.rate) + '%';
                            unit_price -= pr_tax_val;
                        } else {
                            pr_tax_val = formatDecimal(((unit_price) * parseFloat(this.rate)) / 100);
                            pr_tax_rate = formatDecimal(this.rate) + '%';
                        }
                    } else if (this.type == 2) {
                        pr_tax_val = parseFloat(this.rate);
                        pr_tax_rate = this.rate;
                    }
                }
            });
        }

        $('#net_price').text(formatMoney(unit_price));
        $('#pro_tax').text(formatMoney(pr_tax_val));
    });

    $(document).on('change', '#punit', function () {
        var row = $('#' + $('#row_id').val());
        var item_id = row.attr('data-item-id');
        var item = positems[item_id];
        if (!is_numeric($('#pquantity').val()) || parseFloat($('#pquantity').val()) < 0) {
            $(this).val(old_row_qty);
            bootbox.alert(lang.unexpected_value);
            return;
        }
        var opt = $('#poption').val(), unit = $('#punit').val(), base_quantity = $('#pquantity').val(), aprice = 0;
        if (item.options !== false) {
            $.each(item.options, function () {
                if (this.id == opt && this.price != 0 && this.price != '' && this.price != null) {
                    aprice = parseFloat(this.price);
                }
            });
        }
        if (unit != positems[item_id].row.base_unit) {
            $.each(item.units, function () {
                if (this.id == unit) {
                    base_quantity = unitToBaseQty($('#pquantity').val(), this);
                    // $('#pprice').val(formatDecimal(((parseFloat(item.row.base_unit_price)*(unitToBaseQty(1, this)))+(aprice*base_quantity)), 4)).change();
                    $('#pprice').val(formatDecimal(((parseFloat(item.row.base_unit_price + aprice)) * unitToBaseQty(1, this)), 4)).change();
                }
            });
        } else {
            $('#pprice').val(formatDecimal(item.row.base_unit_price + aprice)).change();
        }
    });

    /* -----------------------
     * Edit Row Method
     ----------------------- */
    $(document).on('click', '#editItem', function () {
       
        var row = $('#' + $('#row_id').val());
        var item_id = row.attr('data-item-id'), new_pr_tax = $('#ptax').val(), new_pr_tax_rate = false;
        if (new_pr_tax) {
            $.each(tax_rates, function () {
                if (this.id == new_pr_tax) {
                    new_pr_tax_rate = this;
                }
            });
        }
        var price = parseFloat($('#pprice').val());
        if (item.options !== false) {
            var opt = $('#poption').val();
            $.each(item.options, function () {
                if (this.id == opt && this.price != 0 && this.price != '' && this.price != null) {
                    price = price - parseFloat(this.price);
                }
            });
        }
        if (site.settings.product_discount == 1 && $('#pdiscount').val()) {
            if (!is_valid_discount($('#pdiscount').val())) {
                bootbox.alert(lang.unexpected_value);
                return false;
            }
        }
        if (!is_numeric($('#pquantity').val()) || parseFloat($('#pquantity').val()) < 0) {
            $(this).val(old_row_qty);
            bootbox.alert(lang.unexpected_value);
            return;
        }
        var unit = $('#punit').val();
        var base_quantity = parseFloat($('#pquantity').val());
        if (unit != positems[item_id].row.base_unit) {
            $.each(positems[item_id].units, function () {
                if (this.id == unit) {
                    base_quantity = unitToBaseQty($('#pquantity').val(), this);
                }
            });
        }
                positems[item_id].row.fup = 1,
                positems[item_id].row.qty = parseFloat($('#pquantity').val()),
                positems[item_id].row.base_quantity = parseFloat(base_quantity),
                positems[item_id].row.real_unit_price = price,
                positems[item_id].row.unit = unit,
                positems[item_id].row.sale_unit = unit,
                positems[item_id].row.tax_rate = new_pr_tax,
                positems[item_id].tax_rate = new_pr_tax_rate,
                positems[item_id].row.discount = $('#pdiscount').val() ? $('#pdiscount').val() : '',
                positems[item_id].row.description = $('#pdescription').val() ? $('#pdescription').val() : '',
                positems[item_id].row.option = $('#poption').val() ? $('#poption').val() : '',
                positems[item_id].row.serial = $('#pserial').val();

        //check if option is changed ot not
        //edited by sunny

        var Item = positems[item_id];
        delete positems[item_id];
        resetCartItems();
        localStorage.setItem('positems', JSON.stringify(positems));
        $('#prModal').modal('hide');

        add_invoice_item(Item);
        //loadItems();
        return;
    });

    /* -----------------------
     * Product option change
     ----------------------- */
    $(document).on('change', '#poption', function () {
        var row = $('#' + $('#row_id').val()), opt = $(this).val();
        var item_id = row.attr('data-item-id');
        var item = positems[item_id];
        var unit = $('#punit').val(), base_quantity = parseFloat($('#pquantity').val()), base_unit_price = item.row.base_unit_price;
        if (unit != positems[item_id].row.base_unit) {
            $.each(positems[item_id].units, function () {
                if (this.id == unit) {
                    base_unit_price = formatDecimal((parseFloat(item.row.base_unit_price) * (unitToBaseQty(1, this))), 4)
                    base_quantity = unitToBaseQty($('#pquantity').val(), this);
                }
            });
        }
        $('#pprice').val(parseFloat(base_unit_price)).trigger('change');
        if (item.options !== false) {
            $.each(item.options, function () {
                if (this.id == opt && this.price != 0 && this.price != '' && this.price != null) {
                    $('#pprice').val(parseFloat(base_unit_price) + (parseFloat(this.price))).trigger('change');
                }
            });
        }
    });

    /* ------------------------------
     * Sell Gift Card modal
     ------------------------------- */
    $(document).on('click', '#sellGiftCard', function (e) {
        if (count == 1) {
            positems = {};
            if ($('#poswarehouse').val() && $('#poscustomer').val()) {
                $('#poscustomer').select2("readonly", true);
                $('#poswarehouse').select2("readonly", true);
            } else {
                bootbox.alert(lang.select_above);
                item = null;
                return false;
            }
        }
        $('.gcerror-con').hide();
        $('#gcModal').appendTo("body").modal('show');
        return false;
    });

    $('#gccustomer').select2({
        minimumInputLength: 1,
        ajax: {
            url: site.base_url + "customers/suggestions",
            dataType: 'json',
            quietMillis: 15,
            data: function (term, page) {
                return {
                    term: term,
                    limit: 10
                };
            },
            results: function (data, page) {
                if (data.results != null) {
                    return {results: data.results};
                } else {
                    return {results: [{id: '', text: 'No Match Found'}]};
                }
            }
        }
    });

    $('#genNo').click(function () {
        var no = generateCardNo();
        $(this).parent().parent('.input-group').children('input').val(no);
        return false;
    });
    $('.date').datetimepicker({format: site.dateFormats.js_sdate, fontAwesome: true, language: 'sma', todayBtn: 1, autoclose: 1, minView: 2});
    $(document).on('click', '#addGiftCard', function (e) {
        var mid = (new Date).getTime(),
                gccode = $('#gccard_no').val(),
                gcname = $('#gcname').val(),
                gcvalue = $('#gcvalue').val(),
                gccustomer = $('#gccustomer').val(),
                gcexpiry = $('#gcexpiry').val() ? $('#gcexpiry').val() : '',
                gcprice = $('#gcprice').val();//formatMoney();
        if (gccode == '' || gcvalue == '' || gcprice == '' || gcvalue == 0 || gcprice == 0) {
            $('#gcerror').text('Please fill the required fields');
            $('.gcerror-con').show();
            return false;
        }

        var gc_data = new Array();
        gc_data[0] = gccode;
        gc_data[1] = gcvalue;
        gc_data[2] = gccustomer;
        gc_data[3] = gcexpiry;

        $.ajax({
            type: 'get',
            url: site.base_url + 'sales/sell_gift_card',
            dataType: "json",
            data: {gcdata: gc_data},
            success: function (data) {
                if (data.result === 'success') {
                    positems[mid] = {"id": mid, "item_id": mid, "label": gcname + ' (' + gccode + ')', "row": {"id": mid, "code": gccode, "name": gcname, "quantity": 1, "price": gcprice, "real_unit_price": gcprice, "tax_rate": 0, "qty": 1, "type": "manual", "discount": "0", "serial": "", "option": ""}, "tax_rate": false, "options": false};
                                        
                    localStorage.setItem('positems', JSON.stringify(positems));
                    loadItems();
                    $('#gcModal').modal('hide');
                    $('#gccard_no').val('');
                    $('#gcvalue').val('');
                    $('#gcexpiry').val('');
                    $('#gcprice').val('');
                } else {
                    $('#gcerror').text(data.message);
                    $('.gcerror-con').show();
                }
            }
        });
        return false;
    });

    /* ------------------------------
     * Show manual item addition modal
     ------------------------------- */
    $(document).on('click', '#addManually', function (e) {
        if (count == 1) {
            positems = {};
            if ($('#poswarehouse').val() && $('#poscustomer').val()) {
                $('#poscustomer').select2("readonly", true);
                $('#poswarehouse').select2("readonly", true);
            } else {
                bootbox.alert(lang.select_above);
                item = null;
                return false;
            }
        }
        $('#mnet_price').text('0.00');
        $('#mpro_tax').text('0.00');
        $('#mModal').appendTo("body").modal('show');
        return false;
    });

    $(document).on('click', '#addItemManually', function (e) {
        var mid = (new Date).getTime(),
                mcode = $('#mcode').val(),
                mname = $('#mname').val(),
                mtax = parseInt($('#mtax').val()),
                mqty = parseFloat($('#mquantity').val()),
                mdiscount = $('#mdiscount').val() ? $('#mdiscount').val() : '0',
                unit_price = parseFloat($('#mprice').val()),
                mtax_rate = {};
        if (mcode && mname && mqty && unit_price) {
            $.each(tax_rates, function () {
                if (this.id == mtax) {
                    mtax_rate = this;
                }
            });

            positems[mid] = {"id": mid, "item_id": mid, "label": mname + ' (' + mcode + ')', "row": {"id": mid, "code": mcode, "name": mname, "quantity": mqty, "price": unit_price, "unit_price": unit_price, "real_unit_price": unit_price, "tax_rate": mtax, "tax_method": 0, "qty": mqty, "type": "manual", "discount": mdiscount, "serial": "", "option": ""}, "tax_rate": mtax_rate, 'units': false, "options": false};
            resetCartItems();
            localStorage.setItem('positems', JSON.stringify(positems));
            loadItems();
        }
        $('#mModal').modal('hide');
        $('#mcode').val('');
        $('#mname').val('');
        $('#mtax').val('');
        $('#mquantity').val('');
        $('#mdiscount').val('');
        $('#mprice').val('');
        return false;
    });

    $(document).on('change', '#mprice, #mtax, #mdiscount', function () {
        var unit_price = parseFloat($('#mprice').val());
        var ds = $('#mdiscount').val() ? $('#mdiscount').val() : '0';
        if (ds.indexOf("%") !== -1) {
            var pds = ds.split("%");
            if (!isNaN(pds[0])) {
                item_discount = parseFloat(((unit_price) * parseFloat(pds[0])) / 100);
            } else {
                item_discount = parseFloat(ds);
            }
        } else {
            item_discount = parseFloat(ds);
        }
        unit_price -= item_discount;
        var pr_tax = $('#mtax').val(), item_tax_method = 0;
        var pr_tax_val = 0, pr_tax_rate = 0;
        if (pr_tax !== null && pr_tax != 0) {
            $.each(tax_rates, function () {
                if (this.id == pr_tax) {
                    if (this.type == 1) {
                        if (item_tax_method == 0) {
                            pr_tax_val = formatDecimal(((unit_price) * parseFloat(this.rate)) / (100 + parseFloat(this.rate)));
                            pr_tax_rate = formatDecimal(this.rate) + '%';
                            unit_price -= pr_tax_val;
                        } else {
                            pr_tax_val = formatDecimal(((unit_price) * parseFloat(this.rate)) / 100);
                            pr_tax_rate = formatDecimal(this.rate) + '%';
                        }
                    } else if (this.type == 2) {

                        pr_tax_val = parseFloat(this.rate);
                        pr_tax_rate = this.rate;

                    }
                }
            });
        }

        $('#mnet_price').text(formatMoney(unit_price));
        $('#mpro_tax').text(formatMoney(pr_tax_val));
    });

    /* --------------------------
     * Edit Row Quantity Method
     --------------------------- */
    var old_row_qty;
    $(document).on("focus", '.rquantity', function () {
        old_row_qty = $(this).val();
    }).on("change", '.rquantity', function () {

        var row = $(this).closest('tr');
        if (!is_numeric($(this).val()) || parseFloat($(this).val()) < 0) {
            $(this).val(old_row_qty);
            bootbox.alert(lang.unexpected_value);
            return;
        }
        var new_qty = parseFloat($(this).val()),
                item_id = row.attr('data-item-id');

        positems[item_id].row.base_quantity = new_qty;
        if (positems[item_id].row.unit != positems[item_id].row.base_unit) {
            $.each(positems[item_id].units, function () {
                if (this.id == positems[item_id].row.unit) {
                    positems[item_id].row.base_quantity = unitToBaseQty(new_qty, this);
                }
            });
        }
        positems[item_id].row.qty = new_qty;
        resetCartItems();
        localStorage.setItem('positems', JSON.stringify(positems));
        
        loadItems();
    });

    /* --------------------------
     * Edit Row Price Method
     -------------------------- */
    var old_price;
    $(document).on("focus", '.userprice', function () {
        old_price = $(this).val();

    }).on("change", '.userprice', function () {
        var row = $(this).closest('tr');
        if (!is_numeric($(this).val().replace(/,/g, ''))) {
            $(this).val(old_price);
            bootbox.alert(lang.unexpected_value);
            return;
        }

        //var new_price = parseFloat($(this).val()),
         //       item_id = row.attr('data-item-id');

        var new_price = parseFloat($(this).val().replace(/,/g, '')),
               item_id = row.attr('data-item-id');

        var rowid = $('#item_' + item_id).val();

        /*	$('#price_'+rowid).val(new_price);
         $('.ruprice').val(new_price);*/
        positems[item_id].row.price = new_price;
        positems[item_id].row.real_unit_price = new_price;
        positems[item_id].row.tax_method = 0; // Note :  Manual Price Edit time pass inclusive tax method not using exclusion tax method
        positems[item_id].row.manualedit = 1; // Note :  Manual Price Edit 
        
        resetCartItems();
        
        localStorage.setItem('positems', JSON.stringify(positems));
        loadItems();
    });

//end ready function
});

/* -----------------------
 * Load all items
 * ----------------------- */

//localStorage.clear();
function loadItems() {
    //Set Permissions
    var per_cartunitview = ($('#per_cartunitview').val() == 1) ? true : false;
    var per_cartpriceedit = ($('#per_cartpriceedit').val() == 1) ? true : false;
    var permission_owner = ($('#permission_owner').val() == 1) ? true : false;
    var permission_admin = ($('#permission_admin').val() == 1) ? true : false;    
    var add_tax_in_cart_unit_price = ($('#add_tax_in_cart_unit_price').val() == 1) ? true : false;
    var add_discount_in_cart_unit_price = ($('#add_discount_in_cart_unit_price').val() == 1) ? true : false;
     
       
   if (localStorage.getItem('positems')) {
        total = 0;
        invoice_total_withtax = 0;      //For Apply Offers
        invoice_total_withouttax = 0;   //For Apply Offers 
        offerCartItems = {};            //For Apply Offers 
        count = 1;
        an = 1;
        product_tax = 0;
        invoice_tax = 0;
        product_discount = 0;
        order_discount = 0;
        total_discount = 0;
        poscartitems = null;           
        
        $("#posTable tbody").empty();

        if (java_applet == 1) {
            order_data = "";
            bill_data = "";
            bill_data += chr(27) + chr(69) + "\r" + chr(27) + "\x61" + "\x31\r";
            bill_data += site.settings.site_name + "\n\n";
            order_data = bill_data;
            bill_data += lang.bill + "\n";
            order_data += lang.order + "\n";
            bill_data += $('#select2-chosen-1').text() + "\n\n";
            bill_data += " \x1B\x45\x0A\r\n ";
            order_data += $('#select2-chosen-1').text() + "\n\n";
            order_data += " \x1B\x45\x0A\r\n ";
            bill_data += "\x1B\x61\x30";
            order_data += "\x1B\x61\x30";
        } else {
            $("#order_span").empty();
            $("#bill_span").empty();
            var styles = '<style>table, th, td { border-collapse:collapse; border-bottom: 1px solid #CCC; } .no-border { border: 0; } .bold { font-weight: bold; }</style>';
            var pos_head1 = '<span style="text-align:center;"><h3>' + site.settings.site_name + '</h3><h4>';
            var pos_head2 = '</h4><h5> Token No.: '+tokan_no+' </h5><h5>' + $('#select2-chosen-1').text() + '<br>' + hrld() + '</h5></span>';
            $("#order_span").prepend(styles + pos_head1 + ' Order ' + pos_head2);
            $("#bill_span").prepend(styles + pos_head1 + ' Bill ' + pos_head2);
            $("#order-table").empty();
            $("#bill-table").empty();
        }
        
        positems = JSON.parse(localStorage.getItem('positems'));
        console.log(positems);
        var posItemsCount = Object.keys(positems).length;
         
        var poscartitems = {};
        /*********************Code For Offers Add Free Items*******************/
//         console.log('Status addfreeitems: '+localStorage.getItem('addfreeitems'));
//         console.log('----------------positems--------------'); 
//         console.log(positems); 
         
        if(localStorage.getItem('addfreeitems') == 'false'){ 
             var temp_item_id = '';
            //When do not have to add free items in cart but in localstorage have free items then remove from localstorage and cart
           
            $.each(positems, function () {  
                
                if(this.note == 'Free Items' || this.is_free ){                  

                    var objitemid = '';
                    var objitemid2 = '';

                    if(this.row.option){
                        objitemid  =  this.item_id + this.row.option;
                        objitemid2 =  this.item_id + '_' + this.row.option;
                    }
                    else if(this.category){
                        objitemid  =  this.item_id + this.category;
                        objitemid2 =  this.item_id + '_' + this.category;
                    } else {
                        objitemid  =  this.item_id;
                        objitemid2 =  this.item_id;
                    }
                   
                    delete positems['free_item_' +objitemid2];
                    localStorage.removeItem('free_item_' +objitemid2);
                    
                    delete positems[objitemid];
                    localStorage.removeItem(objitemid);
                } else  {
                    
                    temp_item_id = (this.row.option) ?  this.item_id + this.row.option :  this.item_id;
                    poscartitems[temp_item_id] = this;
                }              
            });
        }
        else { 
            poscartitems = positems;
            
            if(localStorage.getItem('posfreeitems')){
                var freepositems = JSON.parse(localStorage.getItem('posfreeitems'));
                jQuery.extend(poscartitems, freepositems); // Extend cart veriables with free items.
                localStorage.removeItem('posfreeitems');
            }
        }
        
        /**********************************************************************/
         
        if (pos_settings.item_order == 1) {
            sortedItems = _.sortBy(poscartitems, function (o) {
                return [parseInt(o.category), parseInt(o.order)];
            });
        } else if (site.settings.item_addition == 1) {
            sortedItems = _.sortBy(poscartitems, function (o) {
                return [parseInt(o.order)];
            })
        } else {
            sortedItems = poscartitems;
        }
        
//        console.log('--------------sortedItems---------------------');
//        console.log(sortedItems);
                
        //Get the total cart unit items
        var cart_item_unit_count = 0;       
        
         $.each(sortedItems, function () {
              cart_item_unit_count += parseFloat(this.row.qty);
         }); 
        
//        console.log('--------------sortedItems---------------------');
//        console.log(sortedItems);
        
        
        var category = 0, print_cate = false;
        // var itn = parseInt(Object.keys(sortedItems).length);
        $("#bill-table").append('<tr><th>Product</th><th>Qty</th><th>Price</th><th style="text-align:right;">Total</th></tr>');
        var previous_row_no = '';
        $.each(sortedItems, function() {
            
            var item = this;
            var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
            
            if (item.options) {
                item_id = item_id + '' + item.row.option
            }
            
            var hsn_code = '';
            if(item.row.hsn_code){
                hsn_code = item.row.hsn_code;
            }
            // positems[item_id] = item;
           
            item.order = item.order ? item.order : new Date().getTime();
            var product_id = item.row.id, item_type = item.row.type, combo_items = item.combo_items, item_price = item.row.price, item_qty = item.row.qty, item_aqty = item.row.quantity, item_tax_method = item.row.tax_method, item_ds = item.row.discount, item_discount = 0, item_desc = item.row.description, item_option = item.row.option, item_code = item.row.code, item_article_code = item.row.article_code, item_serial = item.row.serial, item_name = item.row.name.replace(/"/g, "&#034;").replace(/'/g, "&#039;");
            var product_unit = item.row.unit, base_quantity = item.row.base_quantity;
            var unit_price = item.row.real_unit_price;
            var manualedit = (item.row.manualedit)?item.row.manualedit:''; // 05-09-19

            var cf1 = item.row.cf1;
            var cf2 = item.row.cf2;
            var cf3 = item.row.cf3;
            var cf4 = item.row.cf4;
            var cf5 = item.row.cf5;
            var cf6 = item.row.cf6;

            if (item.row.fup != 1 && product_unit != item.row.base_unit) {
                $.each(item.units, function () {
                    if (this.id == product_unit) {
                        base_quantity   = formatDecimal(unitToBaseQty(item.row.qty, this), 6);
                        unit_price      = formatDecimal((parseFloat(item.row.base_unit_price) * (unitToBaseQty(1, this))), 6);
                    }
                });
            }
            var sel_opt = '';
            var option_input_hidden = '<input name="product_option[]" type="hidden" class="roption" value="' + item.row.option + '">';
            if(site.settings.attributes==1){
            if (item.options !== false) {
                $.each(item.options, function () {
                    var this_options = this;
                      
                    //If Select multiple options
                    if (jQuery.type(item.row.option) == 'string') {
                        
                        var optionArr = item.row.option.split(",");
                        $.each(optionArr, function (k, opt) {
                            
                            if (this_options.id == opt) {                                 
                                if (this_options.price != 0 && this_options.price != '' && this_options.price != null) {  
                                  if(manualedit == ''){                                   
                                     item_price = formatDecimal(parseFloat(unit_price) + parseFloat(this_options.price),6);
                                     unit_price = item_price;
                                  }  
                                }
                                if (k) {
                                    sel_opt = sel_opt + ',' + this_options.name;
                                } else {
                                    sel_opt = this_options.name;
                                }
                            }
                        });
                    } else {                       
                        if (this_options.id == item.row.option) {
                            if (this_options.price != 0 && this_options.price != '' && this_options.price != null) {
                                if(manualedit == ''){ 
                                    item_price = formatDecimal(parseFloat(unit_price) + (parseFloat(this_options.price)),6);
                                    unit_price = item_price;
                                }
                            }
                            sel_opt = this_options.name;
                        }
                    }
                });
            }
            }          
            // Order level discount distributed in each items as item discount.
            if (posdiscount = localStorage.getItem('posdiscount')) {
                //Order Level Discount Calculations               
                var ods = posdiscount;

                if (ods.indexOf("%") !== -1) {
                    var pds = ods.split("%");
                    if (!isNaN(pds[0])) {
                       item_discount = formatDecimal((parseFloat(((unit_price) * parseFloat(pds[0])) / 100)), 6);
                       item_ds = ods;
                    } else {
                       item_discount = formatDecimal(parseFloat(ods), 6);
                       item_ds = item_discount;
                    }
                } else {                    
                   //If Discount in amount then divided equal in each items unit equally.
                   item_discount = formatDecimal((parseFloat(ods) / cart_item_unit_count), 6);
                   item_ds = item_discount;
                }
                //Set Order Discount Value null.
                $('#posdiscount').val('');
                $('#offer_category').val(localStorage.getItem('offer_category'));
                $('#offer_description').val(localStorage.getItem('offer_description'));
                
               // alert('offer_category: '+localStorage.getItem('offer_category'));
               // alert('offer_description: '+localStorage.getItem('offer_description'));
                localStorage.setItem('applyOffers', true);               
            } else  {                
              //Item Level Discount Calculations  
                var ds = item_ds ? item_ds : '0';
                if (ds.indexOf("%") !== -1) {
                    var pds = ds.split("%");
                    if (!isNaN(pds[0])) {
                        item_discount = formatDecimal((parseFloat(((unit_price) * parseFloat(pds[0])) / 100)), 6);
                    } else {
                        item_discount = formatDecimal(ds,6);
                    }
                } else {
                    item_discount = formatDecimal(ds,6);
                }                
            }//end else
            product_discount += formatDecimal((item_discount * item_qty),6);
            
            unit_price = formatDecimal(unit_price - item_discount,6);
            var pr_tax = item.tax_rate;
            var pr_tax_val = 0, pr_tax_rate = 0;
            if (site.settings.tax1 == 1) {
                if (pr_tax !== false) {
                    if (pr_tax.type == 1) {
                        if (item_tax_method == '0') {
                            pr_tax_val = formatDecimal(((unit_price) * parseFloat(pr_tax.rate)) / (100 + parseFloat(pr_tax.rate)), 6);
                            pr_tax_rate = formatDecimal(pr_tax.rate) + '%';
                        } else {
                            pr_tax_val = formatDecimal(((unit_price) * parseFloat(pr_tax.rate)) / 100, 6);
                            pr_tax_rate = formatDecimal(pr_tax.rate) + '%';
                        }
                    } else if (pr_tax.type == 2) {
                        pr_tax_val = formatDecimal(pr_tax.rate);
                        pr_tax_rate = pr_tax.rate;
                    }
                    product_tax += pr_tax_val * item_qty;
                }
            }//end if.
            item_price = item_tax_method == 0 ? formatDecimal((unit_price - pr_tax_val), 6) : formatDecimal(unit_price,6);
            unit_price = formatDecimal((unit_price + item_discount), 6);
            
            /********************************************/
            if(item_tax_method == 0) {
                offerCartItems[item.row.id] = JSON.parse('{"item_id":"'+item.row.id+'", "price_with_tax":"'+ unit_price + '", "price_without_tax":"' + (parseFloat(unit_price) - parseFloat(pr_tax_val)) + '", "qty":"' + item_qty + '", "category":"' + item.row.category_id + '", "discount":"' + item.row.discount + '"}'); 
            } else {
                offerCartItems[item.row.id] = JSON.parse('{"item_id":"'+item.row.id+'", "price_with_tax":"'+ (parseFloat(unit_price) + parseFloat(pr_tax_val)) + '", "price_without_tax":"' + unit_price + '", "qty":"' + item_qty + '", "category":"' + item.row.category_id + '", "discount":"' + item.row.discount + '"}'); 
            }
            /************************************************/
            
            if (pos_settings.item_order == 1 && category != item.row.category_id) {
                category   = item.row.category_id;
                print_cate = true;
                var newTh  = $('<tr id="category_'+category+'"></tr>');
                newTh.html('<td colspan="100%"><strong>' + item.row.category_name + '</strong></td>');
                newTh.prependTo("#posTable");
            } else {
                print_cate = false;
            }

            var row_no = (new Date).getTime();
            var newTr = $('<tr id="row_' + row_no + '" class="row_' + item_id + '" data-item-id="' + item_id + '"></tr>');

            var tr_html = '<td><input name="row[]" type="hidden" id="item_' + item_id + '" class="roid" value="' + row_no + '">';
            tr_html += '<input name="product_id[]" type="hidden" class="rid" value="' + product_id + '">';           
            tr_html += '<input name="hsn_code[]" type="hidden" class="rid" value="' + hsn_code + '">';
            tr_html += '<input name="product_type[]" type="hidden" class="rtype" value="' + item_type + '">';
            tr_html += '<input name="product_code[]" type="hidden" class="rcode" value="' + item_code + '">';
            tr_html += '<input name="article_code[]" type="hidden" class="rcode" value="' + item_article_code + '">';
            tr_html += '<input name="product_name[]" type="hidden" class="rname" value="' + item_name + '">';
            tr_html += '<input name="manualedit[]" type="hidden" class="rmanualedit" value="' + manualedit + '">'; // Manual Price Edit 05-09-19
            //Options Input Hiddens 
            tr_html += option_input_hidden;

            tr_html += '<span class="sname" id="name_' + row_no + '">' + item_code + ' - ' + item_name + (sel_opt != '' ? ' (' + sel_opt + ((item.note == '') ? item.note : ': ' + item.note) + ')' : '') + '</span>';
            
            //Hide Item Edit Options if Items is free
            if((item.note == 'Free Items')) { 
                var item_disabled = ' readonly="readonly" ';
                tr_html += '</td>';            
            } else {
                var item_disabled = '';
                tr_html += '<i class="pull-right fa fa-edit tip pointer edit" id="' + row_no + '" data-item="' + item_id + '" title="Edit" style="cursor:pointer;"></i></td>';
            }
            
            //tr_html += '<i class="pull-right fa fa-edit tip pointer edit" id="' + row_no + '" data-item="' + item_id + '" title="Edit" style="cursor:pointer;"></i></td>';
            item.note = (item.note==undefined)?'':item.note;
            tr_html += '<input name="item_note[]" type="hidden" class="rid" value="' + item.note + '">';
            tr_html += '<input name="cf1[]" type="hidden" class="rid" value="' + cf1 + '">';
            tr_html += '<input name="cf2[]" type="hidden" class="rid" value="' + cf2 + '">';
            tr_html += '<input name="cf3[]" type="hidden" class="rid" value="' + cf3 + '">';
            tr_html += '<input name="cf4[]" type="hidden" class="rid" value="' + cf4 + '">';
            tr_html += '<input name="cf5[]" type="hidden" class="rid" value="' + cf5 + '">';
            tr_html += '<input name="cf6[]" type="hidden" class="rid" value="' + cf6 + '">';
            tr_html += '<td class="text-right">';

            if (site.settings.product_serial == 1) {
                tr_html += '<input class="form-control input-sm rserial" name="serial[]" type="hidden" id="serial_' + row_no + '" value="' + item_serial + '">';
            }
            if (site.settings.product_discount == 1) {
                tr_html += '<input class="form-control input-sm rdiscount" name="product_discount[]" type="hidden" id="discount_' + row_no + '" value="' + item_ds + '">';
            }
            if (site.settings.tax1 == 1) {
                tr_html += '<input class="form-control input-sm text-right rproduct_tax" name="product_tax[]" type="hidden" id="product_tax_' + row_no + '" value="' + pr_tax.id + '"><input type="hidden" class="sproduct_tax" id="sproduct_tax_' + row_no + '" value="' + formatMoney(pr_tax_val * item_qty) + '">';
            }
            item_desc = item_desc==undefined?'':item_desc;
            tr_html += '<input class="rdescription" name="item_description[]" type="hidden" id="description_' + row_no + '" value="' + item_desc + '">';
            tr_html += '<input class="rprice" name="net_price[]" type="hidden" id="price_' + row_no + '" value="' + item_price + '">';
            tr_html += '<input class="ruprice" name="unit_price[]" type="hidden" value="' + unit_price + '">';
            tr_html += '<input class="realuprice" name="real_unit_price[]" type="hidden" value="' + item.row.real_unit_price + '">';
            
           // var cart_item_price =  (add_tax_in_cart_unit_price == true) ? (parseFloat(item_price) + parseFloat(pr_tax_val)) : parseFloat(item_price);
            //alert(cart_item_price);
            
            var cart_item_price = 0;

            if(add_tax_in_cart_unit_price == true && add_discount_in_cart_unit_price == true ){
                cart_item_price =  parseFloat(item_price) + parseFloat(pr_tax_val) + parseFloat(item_ds) ;
            } else if (add_tax_in_cart_unit_price == true ){
                cart_item_price =  parseFloat(item_price) + parseFloat(pr_tax_val);
            } else if(add_discount_in_cart_unit_price == true){
                cart_item_price =  parseFloat(item_price) + parseFloat(item_ds);
            } else{
                cart_item_price = parseFloat(item_price);
            }
            

            if(permission_admin || permission_owner || per_cartpriceedit){                    
                tr_html += '<input type="text"  maxlength="10" name="item_price[]" id="sprice_' + row_no + '" value="' + formatMoney(cart_item_price) + '"  '+ item_disabled +'  class="form-control input-sm kb-pad text-center userprice" />';
            } else {
                tr_html += formatMoney(parseFloat(cart_item_price)) +'<input type="hidden"  maxlength="10" name="item_price[]" id="sprice_' + row_no + '" value="' + formatMoney(cart_item_price) + '" onchange="return false" class="form-control input-sm kb-pad text-center userprice" />';
            }
                tr_html += '</td>';

            tr_html += '<td><input class="form-control input-sm kb-pad text-center rquantity" maxlength="6" tabindex="' + ((site.settings.set_focus == 1) ? an : (an + 1)) + '" name="quantity[]" '+ item_disabled +' type="text" value="' + item_qty + '" data-id="' + row_no + '" data-item="' + item_id + '" id="quantity_' + row_no + '" onClick="this.select();"><input name="product_unit[]" type="hidden" class="runit" value="' + product_unit + '"><input name="product_base_quantity[]" maxlength="6" type="hidden" class="rbase_quantity" value="' + base_quantity + '"></td>';

            var item_sale_unit = (item_name == 'Gift Card') ? 'pcs' : '';
            if(item.row.sale_unit){
                $.each(item.units, function () {
                    if (this.id == item.row.sale_unit) {
                        item_sale_unit = this.code;
                    }
                });
            }
            //Show/Hide Cart Unit
            if(permission_admin || permission_owner || per_cartunitview){
                tr_html += '<td class="text-center"><small>' + item_sale_unit + '</small></td>';
            }            
            //tr_html += '<td class="text-right"><span class="text-right ssubtotal" id="subtotal_' + row_no + '">' + formatMoney(((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty))) + '</span></td>';
            
            //Hide Item Edit Options if Items is free
            if((item.note == 'Free Items')) {
                tr_html += '<td class="text-center" colspan="2" style="color:green;">Offer Free Item</td>';
            } else {
                tr_html += '<td class="text-right"><span class="text-right ssubtotal" id="subtotal_' + row_no + '">' + formatMoney(parseFloat(cart_item_price) * parseFloat(item_qty)) + '</span></td>';
                tr_html += '<td class="text-center"><i class="fa fa-times tip pointer posdel" id="' + row_no + '" title="Remove" style="cursor:pointer;"></i></td>';
            }
            
            newTr.html(tr_html);
            if (pos_settings.item_order == 1) {
                //newTr.prependTo("#posTable");
                $('#posTable').find('#category_'+category).after(newTr);
            } else {
		if(previous_row_no==''){
		        newTr.prependTo("#posTable");
		}else{
		        $('#posTable').find('#row_'+previous_row_no).before(newTr);
		}
            }
            previous_row_no = row_no;
            
            invoice_total_withtax    += formatDecimal(((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty)), 6);
            invoice_total_withouttax += formatDecimal((parseFloat(item_price) * parseFloat(item_qty)), 6);
            
            total += formatDecimal(((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty)), 6);
            count += parseFloat(item_qty);
            an++;

            $('#payment').attr('disabled', false);
            
            if(site.settings.overselling != 1) {
                if (item_type == 'standard') {
                    if (item.options !== false) {
                        $.each(item.options, function () {
                            if (this.id == item_option && base_quantity > this.quantity) {
                                $('#row_' + row_no).addClass('danger');
                                $('#payment').attr('disabled', true); 
                            }
                        });
                    } else if (base_quantity > item_aqty) {
                        $('#row_' + row_no).addClass('danger');
                        $('#payment').attr('disabled', true);
                    }
                } else if (item_type == 'combo') {
                    if (combo_items === false) {
                        $('#row_' + row_no).addClass('danger');
                        $('#payment').attr('disabled', true);
                    } else {
                        $.each(combo_items, function () {
                            if (parseFloat(this.quantity) < (parseFloat(this.qty) * base_quantity) && this.type == 'standard') {
                                    $('#row_' + row_no).addClass('danger');
                                    $('#payment').attr('disabled', true);
                            }
                        });
                    }
                }
            }

            if (java_applet == 1) {
                bill_data += "#" + (an - 1) + " " + item_name + " (" + item_code + ")" + "\n";
                bill_data += printLine(item_qty + " x " + formatMoney(parseFloat(item_price) + parseFloat(pr_tax_val)) + ": " + formatMoney(((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty)))) + "\n";
                order_data += printLine("#" + (an - 1) + " " + item_name + " (" + item_code + "):" + formatDecimal(item_qty)) + "\n";
            } else {
                if (pos_settings.item_order == 1 && print_cate) {
                    var bprTh = $('<tr></tr>');
                    bprTh.html('<td colspan="100%" class="no-border"><strong>' + item.row.category_name + '</strong></td>');
                    var oprTh = $('<tr></tr>');
                    oprTh.html('<td colspan="100%" class="no-border"><strong>' + item.row.category_name + '</strong></td>');
                    $("#order-table").append(oprTh);
                    //$("#bill-table").append(bprTh);
                }
                var bprTr = '<tr class="row_' + item_id + '" data-item-id="' + item_id + '"><td class="no-border">  ' + item_name + (sel_opt != '' ? ' (' + sel_opt + ')' : '') + ' (' + item_code + (item.options ? '_' + item.row.option : '') + ')</td><td>' + formatDecimal(item_qty) + '</td> <td>' + (item_discount != 0 ? '<del>' + formatMoney(parseFloat(item_price) + parseFloat(pr_tax_val) + item_discount) + '</del>' : '') + formatMoney(parseFloat(item_price) + parseFloat(pr_tax_val)) + '</td><td style="text-align:right;">' + formatMoney(((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty))) + '</td></tr>';
                //var bprTr = '<tr class="row_' + item_id + '" data-item-id="' + item_id + '"><td colspan="2" class="no-border">#'+(an-1)+' '+ item_name + ' (' + item_code + ')</td></tr>';
                //bprTr += '<tr class="row_' + item_id + '" data-item-id="' + item_id + '"><td>(' + formatDecimal(item_qty) + ' x ' + (item_discount != 0 ? '<del>'+formatMoney(parseFloat(item_price) + parseFloat(pr_tax_val) + item_discount)+'</del>' : '') + formatMoney(parseFloat(item_price) + parseFloat(pr_tax_val))+ ')</td><td style="text-align:right;">'+ formatMoney(((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty))) +'</td></tr>';
                var oprTr = '<tr class="row_' + item_id + '" data-item-id="' + item_id + '"><td>#' + (an - 1) + ' ' + item_name + (sel_opt != '' ? ' (' + sel_opt + ')' : '') + ' (' + item_code + (item.options ? '_' + item.row.option : '') + ')</td><td>' + formatDecimal(item_qty) + '</td></tr>';
                $("#order-table").append(oprTr);
                $("#bill-table").append(bprTr);
            }
        });
        
            
        // Order level discount calculations
       /* if (posdiscount = localStorage.getItem('posdiscount')) {
            var ds = posdiscount;
            if (ds.indexOf("%") !== -1) {
                var pds = ds.split("%");
                if (!isNaN(pds[0])) {
                    order_discount = formatDecimal((parseFloat(((total) * parseFloat(pds[0])) / 100)), 4);
                } else {
                    order_discount = parseFloat(ds);
                }
            } else {
                order_discount = parseFloat(ds);
            }
            //total_discount += parseFloat(order_discount);
        }*/

        // Order level tax calculations
        if (site.settings.tax2 != 0) {
            if (postax2 = localStorage.getItem('postax2')) {
                $.each(tax_rates, function () {
                    if (this.id == postax2) {
                        if (this.type == 2) {
                            invoice_tax = formatDecimal(this.rate);
                        }
                        if (this.type == 1) {
                            invoice_tax = formatDecimal((((total - order_discount) * this.rate) / 100), 6);
                        }
                    }
                });
            }
        }

        total = formatDecimal(total, 2);
        product_tax = formatDecimal(product_tax, 2);
        total_discount = formatDecimal(order_discount + product_discount , 2);
         
        // Totals calculations after item addition
        var gtotal = parseFloat(((total + invoice_tax) - order_discount) + shipping);
        $('#total').text(formatMoney(total));
        $('#titems').text((an - 1) + ' (' + formatDecimal(parseFloat(count) - 1) + ')');
        $('#total_items').val((parseFloat(count) - 1));
        $('#tds').text('(' + formatMoney(product_discount) + ') ' + formatMoney(order_discount));
        if (site.settings.tax2 != 0) {
            $('#ttax2').text('(' + formatMoney(product_tax) + ') ' + formatMoney(invoice_tax))
        }
        $('#gtotal').text(formatMoney(gtotal));
        if (java_applet == 1) {
            bill_data += "\n" + printLine(lang_total + ': ' + formatMoney(total)) + "\n";
            bill_data += printLine(lang_items + ': ' + (an - 1) + ' (' + (parseFloat(count) - 1) + ')') + "\n";
            if (total_discount > 0) {
                bill_data += printLine(lang_discount + ': (' + formatMoney(product_discount) + ') ' + formatMoney(order_discount)) + "\n";
            }
            if (site.settings.tax2 != 0 && invoice_tax != 0) {
                bill_data += printLine(lang_tax2 + ': ' + formatMoney(invoice_tax)) + "\n";
            }
            bill_data += printLine(lang_total_payable + ': ' + formatMoney(gtotal)) + "\n";
        } else {
            var bill_totals = '';
            bill_totals += '<tr class="bold"><td>' + lang_total + '</td><td style="text-align:right;">' + formatMoney(total) + '</td></tr>';
            bill_totals += '<tr class="bold"><td>' + lang_items + '</td><td style="text-align:right;">' + (an - 1) + ' (' + (parseFloat(count) - 1) + ')</td></tr>';
            if (order_discount > 0) {
                bill_totals += '<tr class="bold"><td>' + lang_discount + '</td><td style="text-align:right;">' + formatMoney(order_discount) + '</td></tr>';
            }
            if (site.settings.tax2 != 0 && invoice_tax != 0) {
                bill_totals += '<tr class="bold"><td>' + lang_tax2 + '</td><td style="text-align:right;">' + formatMoney(invoice_tax) + '</td></tr>';
            }
            bill_totals += '<tr class="bold"><td>' + lang_total_payable + '</td><td style="text-align:right;">' + formatMoney(gtotal) + '</td></tr>';
            $('#bill-total-table').empty();
            $('#bill-total-table').append(bill_totals);
        }
        if (count > 1) {
            $('#poscustomer').select2("readonly", true);
            $('#poswarehouse').select2("readonly", true);
        } else {
            $('#poscustomer').select2("readonly", false);
            $('#poswarehouse').select2("readonly", false);
        }
        
         // Hide Keybord on mobile and Android device
        if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            $('input').attr("onfocus","blur()");
            KB = true;
        }
        if (KB) {
            display_keyboards();
        }
        if (site.settings.set_focus == 1) {
            $('#add_item').attr('tabindex', an);
            //  $('[tabindex='+(an-1)+']').focus().select();
        } else {
            $('#add_item').attr('tabindex', 1);
            // $('#add_item').focus();
        }
    }
}

function resetCartItems(){
   // alert('reset cart items');
    localStorage.setItem('addfreeitems',false);
    localStorage.removeItem('posdiscount');
}

function checkoutOffers(){
    
    //Condition for Offers is enabled.
    //if(pos_settings.offers_status && (localStorage.getItem('applyOffers')!='true')) {
    if(pos_settings.offers_status) {
           
        var poscart_items = JSON.parse(localStorage.getItem('positems'));   //POS Cart Items
               
        var posItemsCount = Object.keys(poscart_items).length;
       
        var cart_item_unit_count = 0;
        
        var reloadCart = false;  //Reload cart when apply any discount offer
        var addFreeItems = false;  //Add free items when apply any offer
    
        var activeOffers = site.offers;
        var offerOnAmount = '';
        var isOfferValid = false;
        var maxDiscount = 0;
        var offer_count = 0;
        var offerDiscount = 0;
        var freeItemIds = null;
        var freeItemQty = 0;
        var lastInvoiceAmt = 0;
        var offerFreeItems = {};
        
        localStorage.removeItem('addfreeitems');     
        localStorage.removeItem('posdiscount');
       // alert(pos_settings.active_offer_category);
        switch(pos_settings.active_offer_category) {
                
            case 'DISCOUNT_ON_EVENTS': 
                $.each(activeOffers, function () {            
                    var objOffer = this;
                    offer_count++;
                  //check offer duration
                    isOfferValid = offerValidate(objOffer);
                    if(!isOfferValid) { return; } //Continue if offer duration is not valid.

                    offerOnAmount = (parseInt(objOffer.offer_amount_including_tax) == 1) ? invoice_total_withtax : invoice_total_withouttax; 
                    // alert('offer no. '+offer_count+' cart amt: '+offerOnAmount);
                     
                    var offer_on_invoice_amount =  objOffer.offer_on_invoice_amount ? objOffer.offer_on_invoice_amount : 0;
                    //  alert('offer_on_invoice_amount: '+offer_on_invoice_amount);
                    //After first offers, If previous offer_on_invoice_amount is greater than current then return
                    if(offer_count > 1 && lastInvoiceAmt > parseInt(offer_on_invoice_amount) ) { return; } 

                    if(offerOnAmount >= parseInt(offer_on_invoice_amount) ){
                      
                       offerDiscount = objOffer.offer_discount_rate; 
                      // alert('offerDiscount'+offerDiscount);
                       lastInvoiceAmt = parseInt(offer_on_invoice_amount);
                       localStorage.setItem('offer_category', pos_settings.active_offer_category);
                       localStorage.setItem('offer_description', objOffer.offer_invoice_descriptions);
                    }
                });//end offer each
                
                if(offerDiscount) {
                    localStorage.setItem('posdiscount', offerDiscount);
                    reloadCart = true;
                    addFreeItems = false;
                }
            break;
            
            case 'DISCOUNT_ON_INVOICE_AMOUNT': 
                $.each(activeOffers, function () {            
                    var objOffer = this;
                    offer_count++;
                  //check offer duration
                    isOfferValid = offerValidate(objOffer);
                    if(!isOfferValid) { return; } //Continue if offer duration is not valid.

                    offerOnAmount = (parseInt(objOffer.offer_amount_including_tax) == 1) ? invoice_total_withtax : invoice_total_withouttax; 
                    //  alert('offer no. '+offer_count+' cart amt: '+offerOnAmount);
                      
                    var offer_on_invoice_amount =  objOffer.offer_on_invoice_amount ? objOffer.offer_on_invoice_amount : 0;
                   
                    //After first offers, If previous offer_on_invoice_amount is greater than current then return
                    if(offer_count > 1 && lastInvoiceAmt > parseInt(offer_on_invoice_amount) ) { return; } 

                    if(offerOnAmount >= parseInt(offer_on_invoice_amount) ){
                      
                       offerDiscount = objOffer.offer_discount_rate; 
                       
                       lastInvoiceAmt = parseInt(offer_on_invoice_amount);
                       localStorage.setItem('offer_category', pos_settings.active_offer_category);
                       localStorage.setItem('offer_description', objOffer.offer_invoice_descriptions);
                    }
                });//end offer each
                
                if(offerDiscount) {
                    localStorage.setItem('posdiscount', offerDiscount);
                    reloadCart = true;
                    addFreeItems = false;
                }
            break;
                
            case 'FREE_ITEM_ON_INVOICE_AMOUNT':
                $.each(activeOffers, function () {            
                    var objOffer = this;
                    offer_count++;
                  //check offer duration
                    isOfferValid = offerValidate(objOffer);
                    if(!isOfferValid) { return; } //Continue if offer duration is not valid.
                  
                    offerOnAmount = (parseInt(objOffer.offer_amount_including_tax) == 1) ? invoice_total_withtax : invoice_total_withouttax;                    

                    //After first offers, If previous offer_on_invoice_amount is greater than current then return
                    if(offer_count > 1 && lastInvoiceAmt > parseInt(objOffer.offer_on_invoice_amount) ) { return; } 

                    if(offerOnAmount >= parseInt(objOffer.offer_on_invoice_amount) ){
                       //Add Free Items in cart
                        if(objOffer.offer_free_products){

                            localStorage.setItem('offer_category', pos_settings.active_offer_category);
                            localStorage.setItem('offer_description', objOffer.offer_invoice_descriptions);
                            //alert("offer_count "+offer_count+" : "+objOffer.offer_free_products);
                            freeItemIds = objOffer.offer_free_products; 
                            freeItemQty = objOffer.offer_free_products_quantity ? objOffer.offer_free_products_quantity : 1; 
                            
                            lastInvoiceAmt = parseInt(objOffer.offer_on_invoice_amount);
                            
                            reloadCart = false;
                            addFreeItems = false;
                            localStorage.setItem('addfreeitems', true);
                        }
                    }
                });//end offer each
                
                if(localStorage.getItem('addfreeitems')){
                    
                   addOfferFreeItems(freeItemIds, freeItemQty);
                }
                
            break;
               
            case 'BUY_X_GET_Y_FREE':                   
                    $.each(activeOffers, function () {            
                        var objOffer = this;
                      
                        offer_count++;
                        //check offer duration
                        isOfferValid = offerValidate(objOffer);
                       // alert('Offer '+offer_count+' Valid : '+isOfferValid);
                        if(!isOfferValid) { return; } //Continue if offer duration is not valid.
                       // alert('Enter Offer no. '+offer_count);
                        $.each( poscart_items , function () {
                            var objCart = this;
                            
                            if( objOffer.offer_on_products == objCart.item_id) {
                               
                                if( objCart.row.qty >= objOffer.offer_on_products_quantity){

                                    var offerTerm = parseInt(objCart.row.qty / objOffer.offer_on_products_quantity);
                                    freeItemIds = objOffer.offer_free_products; 
                                    freeItemQty = objOffer.offer_free_products_quantity ? (objOffer.offer_free_products_quantity * offerTerm) : 1; 

                                    localStorage.setItem('offer_category', pos_settings.active_offer_category);
                                    localStorage.setItem('offer_description', objOffer.offer_invoice_descriptions);

                                    offerFreeItems[offer_count] = JSON.parse('{"item_id":'+ freeItemIds + ', "item_qty":' + freeItemQty + '}'); 
                                                                         
                                     reloadCart = false;
                                     addFreeItems = false;
                                     localStorage.setItem('addfreeitems', true);
                                }
                            }
                            
                        });
                        
                    });//end offer each
                    
                    if(localStorage.getItem('addfreeitems')){
                        applyFreeItems(offerFreeItems);
                    }
                     
            break; 
            
            case 'FREE_ITEM_ON_GROUPING_QTY':
                
                $.each(activeOffers, function () {  
                    
                    var objOffer = this;
                      
                        offer_count++;
                        //check offer duration
                        isOfferValid = offerValidate(objOffer);
                        if(!isOfferValid) { return; } //Continue if offer duration is not valid.
                        var items_count = 0;
                        var items_qty   = 0;
                        
                        var offer_on_products = objOffer.offer_on_products.split(',');
                         
                        $.each( poscart_items , function () {
                            var objCart = this;
                                                       
                            if(offer_on_products.indexOf(objCart.item_id) != -1)  {  
                                items_count++;
                                items_qty += objCart.row.qty;
                            } 
                        });
                          //  alert("items_count: "+items_count+" | items_qty: "+items_qty);
                        if( items_qty >= objOffer.offer_on_products_quantity && items_count >= objOffer.offer_items_condition ) {

                            var offerTerm = parseInt(items_qty / objOffer.offer_on_products_quantity);
                                freeItemIds = objOffer.offer_free_products; 
                                freeItemQty = objOffer.offer_free_products_quantity ? (objOffer.offer_free_products_quantity * offerTerm) : 1; 

                                localStorage.setItem('offer_category', pos_settings.active_offer_category);
                                localStorage.setItem('offer_description', objOffer.offer_invoice_descriptions);

                                offerFreeItems[offer_count] = JSON.parse('{"item_id":'+ freeItemIds + ', "item_qty":' + freeItemQty + '}'); 

                                reloadCart   = false;
                                addFreeItems = false;
                                localStorage.setItem('addfreeitems', true);
                                 
                        }//end if.
                        
                    });//end offer each
                    
                    if(localStorage.getItem('addfreeitems')){
                        applyFreeItems(offerFreeItems);
                    }
            break; 
            
            
            case 'DISCOUNT_ON_GROUPING_QTY':
                
                $.each(activeOffers, function () {  
                    
                    var objOffer = this;
                      
                        offer_count++;
                        //check offer duration
                        isOfferValid = offerValidate(objOffer);
                        if(!isOfferValid) { return; } //Continue if offer duration is not valid.
                        var items_count = 0;
                        var items_qty   = 0;
                        
                        var offer_on_products = objOffer.offer_on_products.split(',');
                         
                        $.each( poscart_items , function () {
                            var objCart = this;
                            
                            if(offer_on_products.indexOf(objCart.item_id) != -1)
                            {  
                                items_count++;
                                items_qty += objCart.row.qty;
                            } 
                        });
                          //  alert("items_count: "+items_count+" | items_qty: "+items_qty);
                        if( items_qty >= objOffer.offer_on_products_quantity && items_count >= objOffer.offer_items_condition ) {

                                offerDiscount = objOffer.offer_discount_rate; 
                                
                                localStorage.setItem('offer_category', pos_settings.active_offer_category);
                                localStorage.setItem('offer_description', objOffer.offer_invoice_descriptions);
                                 
                        }//end if.
                        
                    });//end offer each
                    
                    if(offerDiscount) {
                        localStorage.setItem('posdiscount', offerDiscount);
                        reloadCart = true;
                        addFreeItems = false;
                    }
            break; 
            
            
            case 'FREE_ITEM_ON_GROUPING_AMOUNTS':
                
                $.each(activeOffers, function () {  
                    
                    var objOffer = this;
                      
                        offer_count++;
                        //check offer duration
                        isOfferValid = offerValidate(objOffer);
                        if(!isOfferValid) { return; } //Continue if offer duration is not valid.
                        var items_count = 0;                        
                        var amount_total_withtax   = 0;
                        var amount_total_withouttax   = 0;
                       
                        var offer_on_products = objOffer.offer_on_products.split(',');
                         
                        $.each(  poscart_items , function () {
                            var objCart = this;
                            
                            if(offer_on_products.indexOf(objCart.item_id) != -1)
                            {  
                                items_count++;                                 
                                amount_total_withouttax += formatDecimal(parseFloat(offerCartItems[objCart.item_id].price_without_tax) * parseFloat(objCart.row.qty));
                                amount_total_withtax    += formatDecimal(parseFloat(offerCartItems[objCart.item_id].price_with_tax) * parseFloat(objCart.row.qty));
                            } 
                        });
                       
                        offerOnAmount = (parseInt(objOffer.offer_amount_including_tax) == 1) ? amount_total_withtax : amount_total_withouttax; 
                        
                        //After first offers, If previous offer_on_invoice_amount is greater than current then return
                        if(offer_count > 1 && lastInvoiceAmt > parseInt(objOffer.offer_on_products_amount) ) { return; } 
                    
                       // alert("items_count: "+items_count+" | productAmount: "+offerOnAmount +" | OfferAmount: "+objOffer.offer_on_products_amount);
                        if( offerOnAmount >= objOffer.offer_on_products_amount && items_count >= objOffer.offer_items_condition ) {
                                                       
                                freeItemIds = objOffer.offer_free_products; 
                                freeItemQty = objOffer.offer_free_products_quantity ? (objOffer.offer_free_products_quantity) : 1; 

                                localStorage.setItem('offer_category', pos_settings.active_offer_category);
                                localStorage.setItem('offer_description', objOffer.offer_invoice_descriptions);
                                                               
                                lastInvoiceAmt = parseInt(objOffer.offer_on_products_amount);
                                
                                reloadCart   = false;
                                addFreeItems = false;
                                localStorage.setItem('addfreeitems', true);
                                                             
                        }//end if.
                        
                    });//end offer each
                    
                    if(localStorage.getItem('addfreeitems')){
                        addOfferFreeItems(freeItemIds, freeItemQty);
                    }
            break;
            
            
            case 'DISCOUNT_ON_GROUPING_AMOUNTS':
                
                  $.each(activeOffers, function () {  
                    
                    var objOffer = this;
                      
                        offer_count++;
                        //check offer duration
                        isOfferValid = offerValidate(objOffer);
                        if(!isOfferValid) { return; } //Continue if offer duration is not valid.
                        var items_count = 0;                        
                        var amount_total_withtax   = 0;
                        var amount_total_withouttax   = 0;
                       
                        var offer_on_products = objOffer.offer_on_products.split(',');
                         
                        $.each(  poscart_items , function () {
                            var objCart = this;
                            
                            if(offer_on_products.indexOf(objCart.item_id) != -1)
                            {  
                                items_count++;                                 
                                amount_total_withouttax += formatDecimal(parseFloat(offerCartItems[objCart.item_id].price_without_tax) * parseFloat(objCart.row.qty));
                                amount_total_withtax    += formatDecimal(parseFloat(offerCartItems[objCart.item_id].price_with_tax) * parseFloat(objCart.row.qty));
                            } 
                        });
                       
                        offerOnAmount = (parseInt(objOffer.offer_amount_including_tax) == 1) ? amount_total_withtax : amount_total_withouttax; 
                        
                        //After first offers, If previous offer_on_invoice_amount is greater than current then return
                        if(offer_count > 1 && lastInvoiceAmt > parseInt(objOffer.offer_on_products_amount) ) { return; } 
                    
                       // alert("items_count: "+items_count+" | productAmount: "+offerOnAmount +" | OfferAmount: "+objOffer.offer_on_products_amount);
                        if( offerOnAmount >= objOffer.offer_on_products_amount && items_count >= objOffer.offer_items_condition ) {
                                                       
                                offerDiscount = objOffer.offer_discount_rate; 

                                localStorage.setItem('offer_category', pos_settings.active_offer_category);
                                localStorage.setItem('offer_description', objOffer.offer_invoice_descriptions);

                               // offerFreeItems[offer_count] = JSON.parse('{"item_id":'+ freeItemIds + ', "item_qty":' + freeItemQty + '}');                                                               
                                lastInvoiceAmt = parseInt(objOffer.offer_on_products_amount);                                                                                             
                        }//end if.
                        
                    });//end offer each
                    
                    if(offerDiscount) {
                        localStorage.setItem('posdiscount', offerDiscount);
                        reloadCart = true;
                        addFreeItems = false;
                    }
            break;
                
            
            case 'DISCOUNT_ON_CATEGORY_AMOUNTS':
                
                  $.each(activeOffers, function () {  
                    
                    var objOffer = this;
                      
                        offer_count++;
                        //check offer duration
                        isOfferValid = offerValidate(objOffer);
                        if(!isOfferValid) { return; } //Continue if offer duration is not valid.
                        var items_count = 0;                        
                        var amount_total_withtax        = 0;
                        var amount_total_withouttax     = 0;
                       
                        var offer_on_category = objOffer.offer_on_category.split(',');
                         
                        $.each( poscart_items , function () {
                            var objCart = this;
                           
                            if(offer_on_category.indexOf(objCart.category) != -1)
                            {   
                                items_count++;                                 
                                amount_total_withouttax += formatDecimal(parseFloat(offerCartItems[objCart.item_id].price_without_tax) * parseFloat(objCart.row.qty));
                                amount_total_withtax    += formatDecimal(parseFloat(offerCartItems[objCart.item_id].price_with_tax) * parseFloat(objCart.row.qty));
                            } 
                        });
                       
                        offerOnAmount = (parseInt(objOffer.offer_amount_including_tax) == 1) ? amount_total_withtax : amount_total_withouttax; 
                        
                        //After first offers, If previous offer_on_invoice_amount is greater than current then return
                        if(offer_count > 1 && lastInvoiceAmt > parseInt(objOffer.offer_on_category_amount) ) { return; } 
                    
                        // alert("items_count: "+items_count+" | productAmount: "+offerOnAmount +" | OfferAmount: "+objOffer.offer_on_category_amount);
                        if( offerOnAmount >= objOffer.offer_on_category_amount && items_count >= parseInt(objOffer.offer_items_condition) ) {
                                                       
                                offerDiscount = objOffer.offer_discount_rate; 

                                localStorage.setItem('offer_category', pos_settings.active_offer_category);
                                localStorage.setItem('offer_description', objOffer.offer_invoice_descriptions);

                                lastInvoiceAmt = parseInt(objOffer.offer_on_category_amount);                                                                                             
                        }//end if.
                        
                    });//end offer each
                    
                    if(offerDiscount) {
                        localStorage.setItem('posdiscount', offerDiscount);
                        reloadCart = true;
                        addFreeItems = false;
                    }
            break;
            
            
            case 'FREE_ITEM_ON_CATEGORY_AMOUNTS':
                
                $.each(activeOffers, function () {  
                    
                    var objOffer = this;
                      
                        offer_count++;
                        //check offer duration
                        isOfferValid = offerValidate(objOffer);
                        if(!isOfferValid) { return; } //Continue if offer duration is not valid.
                        
                        var items_count = 0;                        
                        var amount_total_withtax   = 0;
                        var amount_total_withouttax   = 0;
                       
                        var offer_on_category = objOffer.offer_on_category.split(',');
                         
                        $.each(  poscart_items , function () {
                            var objCart = this;
                            
                            if(offer_on_category.indexOf(objCart.category) != -1)
                            {  
                                items_count++;                                 
                                amount_total_withouttax += formatDecimal(parseFloat(offerCartItems[objCart.item_id].price_without_tax) * parseFloat(objCart.row.qty));
                                amount_total_withtax    += formatDecimal(parseFloat(offerCartItems[objCart.item_id].price_with_tax) * parseFloat(objCart.row.qty));
                            } 
                        });
                       
                        offerOnAmount = (parseInt(objOffer.offer_amount_including_tax) == 1) ? amount_total_withtax : amount_total_withouttax; 
                        
                        //After first offers, If previous offer_on_invoice_amount is greater than current then return
                        if(offer_count > 1 && lastInvoiceAmt > parseInt(objOffer.offer_on_category_amount) ) { return; } 
                    
                       // alert("items_count: "+items_count+" | productAmount: "+offerOnAmount +" | OfferAmount: "+objOffer.offer_on_category_amount);
                       // alert('objOffer.offer_items_condition: '+objOffer.offer_items_condition);
                        if( offerOnAmount >= objOffer.offer_on_category_amount && items_count >= objOffer.offer_items_condition ) {
                                                
                                freeItemIds = objOffer.offer_free_products; 
                                freeItemQty = objOffer.offer_free_products_quantity ? (objOffer.offer_free_products_quantity) : 1; 

                                localStorage.setItem('offer_category', pos_settings.active_offer_category);
                                localStorage.setItem('offer_description', objOffer.offer_invoice_descriptions);
                                
                                lastInvoiceAmt = parseInt(objOffer.offer_on_category_amount);
                                
                                reloadCart   = false;
                                addFreeItems = false;
                                localStorage.setItem('addfreeitems', true);                                                             
                        }//end if.
                        
                    });//end offer each                    
                   
                    if(localStorage.getItem('addfreeitems')){
                        addOfferFreeItems(freeItemIds, freeItemQty);
                    }
            break;
            
            
            case 'FREE_ITEM_ON_CATEGORY_QTY':
                
                $.each(activeOffers, function () {  
                    
                    var objOffer = this;
                      
                        offer_count++;
                        //check offer duration
                        isOfferValid = offerValidate(objOffer);
                        if(!isOfferValid) { return; } //Continue if offer duration is not valid.
                        
                        var items_count = 0;
                        var items_qty   = 0;
                        
                        var offer_on_category = objOffer.offer_on_category.split(',');
                         
                        $.each( poscart_items , function () {
                            var objCart = this;
                           
                            if(offer_on_category.indexOf(objCart.category) != -1)
                            {  
                                items_count++;
                                items_qty += objCart.row.qty;
                            } 
                        });
                          // alert("items_count: "+items_count+" | items_qty: "+items_qty+ " | offer_on_category_quantity: "+objOffer.offer_on_category_quantity);
                        if( items_qty >= parseFloat(objOffer.offer_on_category_quantity) && items_count >= parseInt(objOffer.offer_items_condition) ) {

                            var offerTerm = parseInt(items_qty / parseFloat(objOffer.offer_on_category_quantity));
                                freeItemIds = objOffer.offer_free_products; 
                                freeItemQty = objOffer.offer_free_products_quantity ? (objOffer.offer_free_products_quantity * parseInt(offerTerm)) : 1; 
                               
                                localStorage.setItem('offer_category', pos_settings.active_offer_category);
                                localStorage.setItem('offer_description', objOffer.offer_invoice_descriptions);
                               
                                offerFreeItems[offer_count] = JSON.parse('{"item_id":'+ freeItemIds + ', "item_qty":' + freeItemQty + '}'); 
                                
                                reloadCart   = false;
                                addFreeItems = false;
                                localStorage.setItem('addfreeitems', true);                                 
                        }//end if.
                        
                    });//end offer each
                    
                    if(localStorage.getItem('addfreeitems')){
                        applyFreeItems(offerFreeItems);
                    }
            break; 
            
            
            case 'DISCOUNT_ON_CATEGORY_QTY':
                
                $.each(activeOffers, function () {  
                    
                    var objOffer = this;
                      
                        offer_count++;
                        //check offer duration
                        isOfferValid = offerValidate(objOffer);
                        if(!isOfferValid) { return; } //Continue if offer duration is not valid.
                        
                        var items_count = 0;
                        var items_qty   = 0;
                        
                        var offer_on_category = objOffer.offer_on_category.split(',');
                         
                        $.each( poscart_items , function () {
                            var objCart = this;
                            
                            if(offer_on_category.indexOf(objCart.category) != -1)
                            {  
                                items_count++;
                                items_qty += objCart.row.qty;
                            } 
                        });
                          //  alert("items_count: "+items_count+" | items_qty: "+items_qty);
                        if( items_qty >= objOffer.offer_on_category_quantity && items_count >= parseInt(objOffer.offer_items_condition) ) {

                                offerDiscount = objOffer.offer_discount_rate;
                                localStorage.setItem('offer_category', pos_settings.active_offer_category);
                                localStorage.setItem('offer_description', objOffer.offer_invoice_descriptions);                                 
                        }//end if.
                        
                    });//end offer each
                    
                    if(offerDiscount) {
                        localStorage.setItem('posdiscount', offerDiscount);
                        reloadCart = true;
                        addFreeItems = false;
                    }
            break;
        
                
        }//end switch.
           
        if(addFreeItems){
           //  alert('Add Free Item Qty: '+freeItemQty);
            localStorage.setItem('applyOffers', true);
            addOfferFreeItems(freeItemIds, freeItemQty);          
        }

        if(reloadCart){ 
            // alert('reloadCart: '+reloadCart);
             loadItems();
        } 

    }//endif.
    else
    {
       // alert('Out of order');
        reloadCart = false;
        addFreeItems = false;
        localStorage.removeItem('posdiscount');
        localStorage.removeItem('applyOffers');
        localStorage.removeItem('offer_category');
        localStorage.removeItem('offer_description');
        localStorage.setItem('applyOffers', false);
        localStorage.setItem('addfreeitems', false);
    }
        
    return true;
}

function offerValidate(objOffer){
     
    var isvalid = true;
    
    var today = new Date();  //gets current date and time
   
    var offer_start_time    = objOffer.offer_start_time ? objOffer.offer_start_time : '00:00:00';
    var offer_end_time      = objOffer.offer_end_time ? objOffer.offer_end_time : '23:59:59';
    var Current_Date = $('#Current_Date').val();
    if(objOffer.offer_start_date && objOffer.offer_end_date){
        
        //var offer_start_date    = new Date(objOffer.offer_start_date +' '+ offer_start_time);
        var offer_start_date    = new Date(Current_Date +' '+ offer_start_time);
        var offer_end_date      = new Date(objOffer.offer_end_date +' '+ offer_end_time);

        if(today >= offer_start_date && today <= offer_end_date) {
            isvalid = true;
           //  alert('date: true;');
        } else {
          //  alert('date: false');
            return false;
        }
    } else {
      //  alert('In Time Check');
        var now = today.toTimeString();
        
        if(now >= offer_start_time && now <= offer_end_time){
            isvalid = true;
        //     alert('Time: true');
        } else {
           // alert('Time: false');
            return false;
        }
    }
    
    if(objOffer.offer_on_days){
        var offer_days = objOffer.offer_on_days.split(',');
        
        if(offer_days.indexOf((today.getDay()).toString()) != -1) { 
           isvalid = true;
            //alert('day: true');
        } else {
            //alert('Day: false');
           return false;
            
        }
    } 
    
    if(objOffer.offer_on_warehouses){
        
        var warehouses = objOffer.offer_on_warehouses.split(',');
        var poswh = $('#poswarehouse').val();
        
        if(warehouses.indexOf(poswh.toString()) != -1) { 
           isvalid = true;
            //alert('WP: true');
        } else {
            // alert('WP: false');
           return false;
        }
    }
    
    return isvalid;
    
}

function applyFreeItems(offerFreeItems){
   
     $.each( offerFreeItems , function () {
         var objItems = this;
         
        // alert("Free Items Id:"+objItems.item_id +" Qty:"+ objItems.item_qty);
         
         addOfferFreeItems(objItems.item_id, objItems.item_qty);       
     });
   
   loadItems();
}

function addOfferFreeItems(itemId, itemQty) {
   
   itemQty = itemQty ? itemQty : 1;
   var wh = $('#poswarehouse').val();
   var cu = $('#poscustomer').val();
   
    $.ajax({
        type: "get",
        url: base_url + 'pos/getProductDataById' ,
        data: {code: itemId, warehouse_id: wh, customer_id: cu},
        dataType: "json",
        success: function (data) {
            
//            if (data.options) {
//                product_option_model_call(data);
//                $(this).val('');
//                return true;
//            }
//            e.preventDefault();
            if (data !== null) {
                 
                add_free_invoice_item(data, itemQty);
            }
        },
        fail: function (e) {
           alert('Discount free item not found');
        }
    });
}

function add_free_invoice_item(item, itemQty) {
   
    if (count == 1) {
        
        if ($('#poswarehouse').val() && $('#poscustomer').val()) {
            $('#poscustomer').select2("readonly", true);
            $('#poswarehouse').select2("readonly", true);
        } else {
            bootbox.alert(lang.select_above);
            item = null;
            return;
        }
    }
    
    if (item == null) return;

    var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;

    if (item.options) {
        item_id = item_id + '_' + item.row.option;
    }
    else if (item.category) {
        item_id = item_id + '_' + item.category;
    }
    var itemtype = 'free_item_'+item_id;
    
    if (offer_free_items[itemtype]) {
        offer_free_items[itemtype].row.qty = itemQty;       
        offer_free_items[itemtype].row.base_quantity = formatDecimal(itemQty,2);
    } else {
        offer_free_items[itemtype] = item;
        offer_free_items[itemtype].row.hsn_code = (item.row.hsn_code ? item.row.hsn_code : null);
        offer_free_items[itemtype].row.qty = itemQty;
        offer_free_items[itemtype].row.base_quantity = formatDecimal(itemQty,2);
        offer_free_items[itemtype].row.discount = 0;
        offer_free_items[itemtype].row.divisionid = 0;
        offer_free_items[itemtype].row.price = 0;
        offer_free_items[itemtype].row.real_unit_price = 0;
        offer_free_items[itemtype].row.base_unit_price = 0;
    }
    
    offer_free_items[itemtype].note    = 'Free Items';
    offer_free_items[itemtype].is_free = item_id;
   
    offer_free_items[itemtype].order = new Date().getTime();
    
    if(localStorage.getItem('posfreeitems')){        
        posfreeitems = localStorage.getItem('posfreeitems');        
        jQuery.extend(posfreeitems, positems);
        localStorage.setItem('posfreeitems', JSON.stringify(offer_free_items));
    } else {  
      
        localStorage.setItem('posfreeitems', JSON.stringify(offer_free_items));
    }
    
    $('#offer_category').val(localStorage.getItem('offer_category'));
    $('#offer_description').val(localStorage.getItem('offer_description'));
                
    loadItems(); 
}

function getPercentageToAmount(percentage , percentageOnAmount){
    var ds = percentage;
    if (ds.indexOf("%") !== -1) {
        var pds = ds.split("%");
        if (!isNaN(pds[0])) {
            amount = formatDecimal((parseFloat(((percentageOnAmount) * parseFloat(pds[0])) / 100)), 4);
        } else {
            amount = parseFloat(ds);
        }
    } else {
        amount = parseFloat(ds);
    }
    return amount;
}

function printLine(str) {
    var size = pos_settings.char_per_line;
    var len = str.length;
    var res = str.split(":");
    var newd = res[0];
    for (i = 1; i < (size - len); i++) {
        newd += " ";
    }
    newd += res[1];
    return newd;
}

/* -----------------------------
 * Add Purchase Iten Function
 * @param {json} item
 * @returns {Boolean}
 ---------------------------- */

function add_invoice_item(item) {
   
    if (count == 1) {
        positems = {};
        if ($('#poswarehouse').val() && $('#poscustomer').val()) {
            $('#poscustomer').select2("readonly", true);
            $('#poswarehouse').select2("readonly", true);
        } else {
            bootbox.alert(lang.select_above);
            item = null;
            return;
        }
    }
  
    if (item == null)
        return;

    var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;

    if (item.options) {
        item_id = item_id + '' + item.row.option;
    }

    if (positems[item_id]) {
        positems[item_id].row.qty = parseFloat(positems[item_id].row.qty) + 1;
        positems[item_id].row.quantity = parseFloat(positems[item_id].row.qty) + 1;
        positems[item_id].row.base_quantity = parseFloat(positems[item_id].row.base_quantity) + 1;
        positems[item_id].note = item.note;

    } else {
        positems[item_id] = item;
    }

    positems[item_id].order = new Date().getTime();
    
    localStorage.setItem('positems', JSON.stringify(positems));
   
    resetCartItems();
    
    loadItems();
    
    return true;
}


if (typeof (Storage) === "undefined") {
    $(window).bind('beforeunload', function (e) {
        if (count > 1) {
            var message = "You will loss data!";
            return message;
        }
    });
}

function display_keyboards() {

    $('.kb-text').keyboard({
        autoAccept: true,
        alwaysOpen: false,
        openOn: 'focus',
        usePreview: false,
        layout: 'custom',
        //layout: 'qwerty',
        display: {
            'bksp': "\u2190",
            'accept': 'return',
            'default': 'ABC',
            'meta1': '123',
            'meta2': '#+='
        },
        customLayout: {
            'default': [
                'q w e r t y u i o p {bksp}',
                'a s d f g h j k l {enter}',
                '{s} z x c v b n m , . {s}',
                '{meta1} {space} {cancel} {accept}'
            ],
            'shift': [
                'Q W E R T Y U I O P {bksp}',
                'A S D F G H J K L {enter}',
                '{s} Z X C V B N M / ? {s}',
                '{meta1} {space} {meta1} {accept}'
            ],
            'meta1': [
                '1 2 3 4 5 6 7 8 9 0 {bksp}',
                '- / : ; ( ) \u20ac & @ {enter}',
                '{meta2} . , ? ! \' " {meta2}',
                '{default} {space} {default} {accept}'
            ],
            'meta2': [
                '[ ] { } # % ^ * + = {bksp}',
                '_ \\ | &lt; &gt; $ \u00a3 \u00a5 {enter}',
                '{meta1} ~ . , ? ! \' " {meta1}',
                '{default} {space} {default} {accept}'
            ]}
    });
    $('.kb-pad').keyboard({
        restrictInput: true,
        preventPaste: true,
        autoAccept: true,
        alwaysOpen: false,
        openOn: 'click',
        usePreview: false,
        layout: 'custom',
        display: {
            'b': '\u2190:Backspace',
        },
        customLayout: {
            'default': [
                '1 2 3 {b}',
                '4 5 6 . {clear}',
                '7 8 9 0 %',
                '{accept} {cancel}'
            ]
        }
    });
    var cc_key = (site.settings.decimals_sep == ',' ? ',' : '{clear}');
    $('.kb-pad1').keyboard({
        restrictInput: true,
        preventPaste: true,
        autoAccept: true,
        alwaysOpen: false,
        openOn: 'click',
        usePreview: false,
        layout: 'custom',
        display: {
            'b': '\u2190:Backspace',
        },
        customLayout: {
            'default': [
                '1 2 3 {b}',
                '4 5 6 . ' + cc_key,
                '7 8 9 0 %',
                '{accept} {cancel}'
            ]
        }
    });

}

/*$(window).bind('beforeunload', function(e) {
 if(count > 1){
 var msg = 'You will loss the sale data.';
 (e || window.event).returnValue = msg;
 return msg;
 }
 });
 */
if (site.settings.auto_detect_barcode == 1) {
    $(document).ready(function () {
        var pressed = false;
        var chars = [];
        $(window).keypress(function (e) {
            if (e.key == '%') {
                pressed = true;
            }
            chars.push(String.fromCharCode(e.which));
            if (pressed == false) {
                setTimeout(function () {
                    if (chars.length >= 8) {
                        var barcode = chars.join("");
                        //$("#add_item").focus().autocomplete("search", barcode);
                    }
                    chars = [];
                    pressed = false;
                }, 200);
            }
            pressed = true;
        });
    });
}

$(document).ready(function () {
    read_card();
});

function generateCardNo(x) {
    if (!x) {
        x = 16;
    }
    chars = "1234567890";
    no = "";
    for (var i = 0; i < x; i++) {
        var rnum = Math.floor(Math.random() * chars.length);
        no += chars.substring(rnum, rnum + 1);
    }
    return no;
}
function roundNumber(number, toref) {
    switch (toref) {
        case 1:
            var rn = formatDecimal(Math.round(number * 20) / 20);
            break;
        case 2:
            var rn = formatDecimal(Math.round(number * 2) / 2);
            break;
        case 3:
            var rn = formatDecimal(Math.round(number));
            break;
        case 4:
            var rn = formatDecimal(Math.ceil(number));
            break;
        default:
            var rn = number;
    }
    return rn;
}
function getNumber(x) {
    return accounting.unformat(x);
}
function formatQuantity(x) {
    return (x != null) ? '<div class="text-center">' + formatNumber(x, site.settings.qty_decimals) + '</div>' : '';
}
function formatNumber(x, d) {
    if (!d && d != 0) {
        d = site.settings.decimals;
    }
    if (site.settings.sac == 1) {
        return formatSA(parseFloat(x).toFixed(d));
    }
    return accounting.formatNumber(x, d, site.settings.thousands_sep == 0 ? ' ' : site.settings.thousands_sep, site.settings.decimals_sep);
}
function formatMoney(x, symbol) {
    if (!symbol) {
        symbol = "";
    }
    if (site.settings.sac == 1) {
        return symbol + '' + formatSA(parseFloat(x).toFixed(site.settings.decimals));
    }
    return accounting.formatMoney(x, symbol, site.settings.decimals, site.settings.thousands_sep == 0 ? ' ' : site.settings.thousands_sep, site.settings.decimals_sep, "%s%v");
}
function formatCNum(x) {
    if (site.settings.decimals_sep == ',') {
        var x = x.toString();
        var x = x.replace(",", ".");
        return parseFloat(x);
    }
    return x;
}
function formatDecimal(x, d) {
    if (!d) {
        d = site.settings.decimals;
    }
    return parseFloat(accounting.formatNumber(x, d, '', '.'));
}
function hrsd(sdate) {
    return moment().format(site.dateFormats.js_sdate.toUpperCase())
}

function hrld(ldate) {
    return moment().format(site.dateFormats.js_sdate.toUpperCase() + ' H:mm')
}
function is_valid_discount(mixed_var) {
    return (is_numeric(mixed_var) || (/([0-9]%)/i.test(mixed_var))) ? true : false;
}
function is_numeric(mixed_var) {
    var whitespace =
            " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
    return (typeof mixed_var === 'number' || (typeof mixed_var === 'string' && whitespace.indexOf(mixed_var.slice(-1)) === -
            1)) && mixed_var !== '' && !isNaN(mixed_var);
}
function is_float(mixed_var) {
    return +mixed_var === mixed_var && (!isFinite(mixed_var) || !!(mixed_var % 1));
}
function currencyFormat(x) {
    if (x != null) {
        return formatMoney(x);
    } else {
        return '0';
    }
}
function formatSA(x) {
    x = x.toString();
    var afterPoint = '';
    if (x.indexOf('.') > 0)
        afterPoint = x.substring(x.indexOf('.'), x.length);
    x = Math.floor(x);
    x = x.toString();
    var lastThree = x.substring(x.length - 3);
    var otherNumbers = x.substring(0, x.length - 3);
    if (otherNumbers != '')
        lastThree = ',' + lastThree;
    var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;

    return res;
}

function unitToBaseQty(qty, unitObj) {
    switch (unitObj.operator) {
        case '*':
            return parseFloat(qty) * parseFloat(unitObj.operation_value);
            break;
        case '/':
            return parseFloat(qty) / parseFloat(unitObj.operation_value);
            break;
        case '+':
            return parseFloat(qty) + parseFloat(unitObj.operation_value);
            break;
        case '-':
            return parseFloat(qty) - parseFloat(unitObj.operation_value);
            break;
        default:
            return parseFloat(qty);
    }
}

function baseToUnitQty(qty, unitObj) {
    switch (unitObj.operator) {
        case '*':
            return parseFloat(qty) / parseFloat(unitObj.operation_value);
            break;
        case '/':
            return parseFloat(qty) * parseFloat(unitObj.operation_value);
            break;
        case '+':
            return parseFloat(qty) - parseFloat(unitObj.operation_value);
            break;
        case '-':
            return parseFloat(qty) + parseFloat(unitObj.operation_value);
            break;
        default:
            return parseFloat(qty);
    }
}

function read_card() {
    var typingTimer;

    $('.swipe').keyup(function (e) {
        e.preventDefault();
        var self = $(this);
        clearTimeout(typingTimer);
        typingTimer = setTimeout(function () {
            var payid = self.attr('id');
            var id = payid.substr(payid.length - 1);
            var v = self.val();
            var p = new SwipeParserObj(v);

            if (p.hasTrack1) {
                var CardType = null;
                var ccn1 = p.account.charAt(0);
                if (ccn1 == 4)
                    CardType = 'Visa';
                else if (ccn1 == 5)
                    CardType = 'MasterCard';
                else if (ccn1 == 3)
                    CardType = 'Amex';
                else if (ccn1 == 6)
                    CardType = 'Discover';
                else
                    CardType = 'Visa';

                $('#pcc_no_' + id).val(p.account);
                $('#pcc_holder_' + id).val(p.account_name);
                $('#pcc_month_' + id).val(p.exp_month);
                $('#pcc_year_' + id).val(p.exp_year);
                $('#pcc_cvv2_' + id).val('');
                $('#pcc_type_' + id).val(CardType);
                self.val('');
                $('#pcc_cvv2_' + id).focus();
            } else {
                $('#pcc_no_' + id).val('');
                $('#pcc_holder_' + id).val('');
                $('#pcc_month_' + id).val('');
                $('#pcc_year_' + id).val('');
                $('#pcc_cvv2_' + id).val('');
                $('#pcc_type_' + id).val('');
            }
        }, 100);
    });

    $('.swipe').keydown(function (e) {
        clearTimeout(typingTimer);
    });
}

function check_add_item_val() {
    $('#add_item').bind('keypress', function (e) {
        if (e.keyCode == 13 || e.keyCode == 9) {
            e.preventDefault();
           // $(this).autocomplete("search");
        }
    });
}

function nav_pointer() {
    var pp = p_page == 'n' ? 0 : p_page;
    (pp == 0) ? $('#previous').attr('disabled', true) : $('#previous').attr('disabled', false);
    ((pp + pro_limit) > tcp) ? $('#next').attr('disabled', true) : $('#next').attr('disabled', false);
}


$.extend($.keyboard.keyaction, {
    enter: function (base) {
        if (base.$el.is("textarea")) {
            base.insertText('\r\n');
        } else {
            base.accept();
        }
    }
});

$(document).ajaxStart(function () {
    $('#ajaxCall').hide();
}).ajaxStop(function () {
    $('#ajaxCall').hide();
});

$(document).ready(function () {
    nav_pointer();
    $('#myModal').on('hidden.bs.modal', function () {
        $(this).find('.modal-dialog').empty();
        $(this).removeData('bs.modal');
    });
    $('#myModal2').on('hidden.bs.modal', function () {
        $(this).find('.modal-dialog').empty();
        $(this).removeData('bs.modal');
        $('#myModal').css('zIndex', '1050');
        $('#myModal').css('overflow-y', 'scroll');
    });
    $('#myModal2').on('show.bs.modal', function () {
        $('#myModal').css('zIndex', '1040');
    });
    $('.modal').on('hidden.bs.modal', function () {
        $(this).removeData('bs.modal');
    });
    $('.modal').on('show.bs.modal', function () {
        $('#modal-loading').show();
      $('#modal-loading').find('.blackbg').css('zIndex', '1041');
        $('#modal-loading').find('.loader').css('zIndex', '1042');
    }).on('hide.bs.modal', function () {
        $('#modal-loading').hide();
       $('#modal-loading').find('.blackbg').css('zIndex', '3');
        $('#modal-loading').find('.loader').css('zIndex', '4');
    });
    $('#clearLS').click(function (event) {
        bootbox.confirm("Are you sure?", function (result) {
            if (result == true) {
                localStorage.clear();
                location.reload();
            }
        });
        return false;
    });
});

//$.ajaxSetup ({ cache: false, headers: { "cache-control": "no-cache" } });
if (pos_settings.focus_add_item != '') {
    shortcut.add(pos_settings.focus_add_item, function () {
        $("#add_item").focus();
    }, {'type': 'keydown', 'propagate': false, 'target': document});
}
if (pos_settings.add_manual_product != '') {
    shortcut.add(pos_settings.add_manual_product, function () {
        $("#addManually").trigger('click');
    }, {'type': 'keydown', 'propagate': false, 'target': document});
}
if (pos_settings.customer_selection != '') {
    shortcut.add(pos_settings.customer_selection, function () {
    $('#customer_name').select2('focus');
      $('#customer_name').trigger('click');
      $('#customer_name').trigger('focus');
      $("#customer_name").select2("open");
    }, {'type': 'keydown', 'propagate': false, 'target': document});
}
if (pos_settings.add_customer != '') {
    shortcut.add(pos_settings.add_customer, function () {
        $("#add-customer").trigger('click');
    }, {'type': 'keydown', 'propagate': false, 'target': document});
}
if (pos_settings.toggle_category_slider != '') {
    shortcut.add(pos_settings.toggle_category_slider, function () {
        $("#open-category").trigger('click');
    }, {'type': 'keydown', 'propagate': false, 'target': document});
}
if (pos_settings.toggle_brands_slider != '') {
    shortcut.add(pos_settings.toggle_brands_slider, function () {
        $("#open-brands").trigger('click');
    }, {'type': 'keydown', 'propagate': false, 'target': document});
}
if (pos_settings.toggle_subcategory_slider != '') {
    shortcut.add(pos_settings.toggle_subcategory_slider, function () {
        $("#open-subcategory").trigger('click');
    }, {'type': 'keydown', 'propagate': false, 'target': document});
}
if (pos_settings.cancel_sale != '') {
    shortcut.add(pos_settings.cancel_sale, function () {
        $("#reset").click();
    }, {'type': 'keydown', 'propagate': false, 'target': document});
}
if (pos_settings.suspend_sale != '') {
    shortcut.add(pos_settings.suspend_sale, function () {
        $("#suspend").trigger('click');
    }, {'type': 'keydown', 'propagate': false, 'target': document});
}
if (pos_settings.print_items_list != '') {
    shortcut.add(pos_settings.print_items_list, function () {
        $("#print_btn").click();
    }, {'type': 'keydown', 'propagate': false, 'target': document});
}
if (pos_settings.finalize_sale != '') {
    shortcut.add(pos_settings.finalize_sale, function () {
        if ($('#paymentModal').is(':visible')) {
            $("#submit-sale").click();
        } else {
            $("#payment").trigger('click');
        }
    }, {'type': 'keydown', 'propagate': false, 'target': document});
}
if (pos_settings.submit_and_print != '') {
    shortcut.add(pos_settings.submit_and_print, function () {
        $(".cmdprint").click();
    }, {'type': 'keydown', 'propagate': false, 'target': document});
}
if (pos_settings.other != '') {
    shortcut.add(pos_settings.other, function () {
       $(".cmdprint1 ").click();
    }, {'type': 'keydown', 'propagate': false, 'target': document});
}
if (pos_settings.today_sale != '') {
    shortcut.add(pos_settings.today_sale, function () {
        $("#today_sale").click();
    }, {'type': 'keydown', 'propagate': false, 'target': document});
}
if (pos_settings.open_hold_bills != '') {
    shortcut.add(pos_settings.open_hold_bills, function () {
        $("#opened_bills").trigger('click');
    }, {'type': 'keydown', 'propagate': false, 'target': document});
}
if (pos_settings.close_register != '') {
    shortcut.add(pos_settings.close_register, function () {
        $("#close_register").click();
    }, {'type': 'keydown', 'propagate': false, 'target': document});
}
shortcut.add("ESC", function () {
    $("#cp").trigger('click');
}, {'type': 'keydown', 'propagate': false, 'target': document});


if (site.settings.set_focus != 1) {
    $(document).ready(function () {
        //$('#add_item').focus();
    });
}


