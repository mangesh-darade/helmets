// Split order start
localStorage.clear();
function loadSplitOrderPayItems (set_item_name, order_name) {
  if (localStorage.getItem(set_item_name)) {
    var customer = (localStorage.getItem('poscustomer')) ? localStorage.getItem('poscustomer') : ''

    total = 0
    count = 1
    an = 1
    product_tax = 0
    invoice_tax = 0
    product_discount = 0
    order_discount = 0
    total_discount = 0

    var positems = JSON.parse(localStorage.getItem(set_item_name))
    if (pos_settings.item_order == 1) {
      sortedItems = _.sortBy(positems, function (o) {
        return [parseInt(o.category), parseInt(o.order)]
      })
    } else if (site.settings.item_addition == 1) {
      sortedItems = _.sortBy(positems, function (o) {
        return [parseInt(o.order)]
      })
    } else {
      sortedItems = positems
    }
    var category = 0, print_cate = false

    var post_html_hidden_elements = ''
    post_html_hidden_elements += "<input type='hidden' name='customer' value='" + customer + "'>"
    post_html_hidden_elements += "<input type='hidden' name='warehouse' value='" + $('#poswarehouse').val() + "' >"
    post_html_hidden_elements += "<input type='hidden' name='biller' value='" + $('#posbiller').val() + "' >"
    post_html_hidden_elements += "<input type='hidden' name='suspend' value='yes' >"
    post_html_hidden_elements += "<input type='hidden' name='suspend_note' value='" + order_name + "' >"
    post_html_hidden_elements += "<input type='hidden' name='staff_note' value='' >"

    $.each(sortedItems, function () {
      var item = this
      var item_id = site.settings.item_addition == 1 ? item.item_id : item.id
      if (item.options) {
        item_id = item_id + '' + item.row.option
      }
      // console.log(item_id);
      var hsn_code = item.row.hsn_code
      positems[item_id] = item
      item.order = item.order ? item.order : new Date().getTime()
      var product_id = item.row.id, item_type = item.row.type, combo_items = item.combo_items,
        item_price = item.row.price, item_qty = item.row.qty, item_aqty = item.row.quantity,
        item_tax_method = item.row.tax_method, item_ds = item.row.discount, item_discount = 0,
        item_option = item.row.option, item_code = item.row.code, item_serial = item.row.serial,
        item_name = item.row.name.replace(/"/g, '&#034;').replace(/'/g, '&#039;')
      var product_unit = item.row.unit, base_quantity = item.row.base_quantity
      var unit_price = item.row.real_unit_price

      var cf1 = item.row.cf1
      var cf2 = item.row.cf2
      var cf3 = item.row.cf3
      var cf4 = item.row.cf4
      var cf5 = item.row.cf5
      var cf6 = item.row.cf6

      if (item.row.fup != 1 && product_unit != item.row.base_unit) {
        $.each(item.units, function () {
          if (this.id == product_unit) {
            base_quantity = formatDecimal(unitToBaseQty(item.row.qty, this), 4)
            unit_price = formatDecimal((parseFloat(item.row.base_unit_price) * (unitToBaseQty(1, this))), 4)
          }
        })
      }
      if (item.options !== false) {
        $.each(item.options, function () {
          if (this.id == item.row.option && this.price != 0 && this.price != '' && this.price != null) {
            item_price = unit_price + (parseFloat(this.price))
            unit_price = item_price
          }
        })
      }

      var ds = item_ds || '0'
      if (ds.indexOf('%') !== -1) {
        var pds = ds.split('%')
        if (!isNaN(pds[0])) {
          item_discount = formatDecimal((parseFloat(((unit_price) * parseFloat(pds[0])) / 100)), 4)
        } else {
          item_discount = formatDecimal(ds)
        }
      } else {
        item_discount = formatDecimal(ds)
      }
      product_discount += formatDecimal(item_discount * item_qty)

      unit_price = formatDecimal(unit_price - item_discount)
      var pr_tax = item.tax_rate
      var pr_tax_val = 0, pr_tax_rate = 0
      if (site.settings.tax1 == 1) {
        if (pr_tax !== false) {
          if (pr_tax.type == 1) {
            if (item_tax_method == '0') {
              pr_tax_val = formatDecimal(((unit_price) * parseFloat(pr_tax.rate)) / (100 + parseFloat(pr_tax.rate)), 4)
              pr_tax_rate = formatDecimal(pr_tax.rate) + '%'
            } else {
              pr_tax_val = formatDecimal(((unit_price) * parseFloat(pr_tax.rate)) / 100, 4)
              pr_tax_rate = formatDecimal(pr_tax.rate) + '%'
            }
          } else if (pr_tax.type == 2) {
            pr_tax_val = formatDecimal(pr_tax.rate)
            pr_tax_rate = pr_tax.rate
          }
          product_tax += pr_tax_val * item_qty
        }
      }
      item_price = item_tax_method == 0 ? formatDecimal((unit_price - pr_tax_val), 4) : formatDecimal(unit_price)
      unit_price = formatDecimal((unit_price + item_discount), 4)
      var sel_opt = ''
      $.each(item.options, function () {
        if (this.id == item_option) {
          sel_opt = this.name
        }
      })

      if (pos_settings.item_order == 1 && category != item.row.category_id) {
        category = item.row.category_id
        print_cate = true
      } else {
        print_cate = false
      }

      total += formatDecimal(((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty)), 4)
      count += parseFloat(item_qty)
      var row_no = (new Date()).getTime()

      // post item wise values
      post_html_hidden_elements += "<input type='hidden' name='row[]' value='" + row_no + "' >"
      post_html_hidden_elements += "<input type='hidden' name='product_id[]' value='" + item.row.id + "' >"
      post_html_hidden_elements += "<input type='hidden' name='hsn_code[]' value='" + item.row.hsn_code + "' >"
      post_html_hidden_elements += "<input type='hidden' name='product_type[]' value='" + item.row.type + "' >"
      post_html_hidden_elements += "<input type='hidden' name='product_code[]' value='" + item.row.code + "' >"
      post_html_hidden_elements += "<input type='hidden' name='product_name[]' value='" + item.row.name.replace(/"/g, '&#034;').replace(/'/g, '&#039;') + "' >"
      post_html_hidden_elements += "<input type='hidden' name='product_option[]' value='" + item.row.option + "'>" // true/false
      post_html_hidden_elements += "<input type='hidden' name='cf1[]' value='" + item.row.cf1 + "' >"
      post_html_hidden_elements += "<input type='hidden' name='cf2[]' value='" + item.row.cf2 + "' >"
      post_html_hidden_elements += "<input type='hidden' name='cf3[]' value='" + item.row.cf3 + "' >"
      post_html_hidden_elements += "<input type='hidden' name='cf4[]' value='" + item.row.cf4 + "' >"
      post_html_hidden_elements += "<input type='hidden' name='cf5[]' value='" + item.row.cf5 + "' >"
      post_html_hidden_elements += "<input type='hidden' name='cf6[]' value='" + item.row.cf6 + "' >"
      post_html_hidden_elements += "<input type='hidden' name='serial[]' value='" + item.row.cf1 + "' >"
      post_html_hidden_elements += "<input type='hidden' name='product_discount[]' value='" + item.row.discount + "' >"
      post_html_hidden_elements += "<input type='hidden' name='product_tax[]' value='" + pr_tax.id + "' >"
      post_html_hidden_elements += "<input type='hidden' name='net_price[]' value='" + item_price + "' >"
      post_html_hidden_elements += "<input type='hidden' name='unit_price[]' value='" + unit_price + "' >"
      post_html_hidden_elements += "<input type='hidden' name='real_unit_price[]' value='" + item.row.real_unit_price + "' >"
      post_html_hidden_elements += "<input type='hidden' name='quantity[]' value='" + formatDecimal(item_qty) + "' >"
      post_html_hidden_elements += "<input type='hidden' name='product_unit[]' value='" + product_unit + "' >"
      post_html_hidden_elements += "<input type='hidden' name='product_base_quantity[]' value='" + base_quantity + "' >"
      post_html_hidden_elements += "<input type='hidden' name='amount[]' value='' >"
      post_html_hidden_elements += "<input type='hidden' name='balance_amount[]' value='' >"
      post_html_hidden_elements += "<input type='hidden' name='paid_by[]' value='' >"
      post_html_hidden_elements += "<input type='hidden' name='cc_no[]' value='' >"
      post_html_hidden_elements += "<input type='hidden' name='paying_gift_card_no[]' value='' >"
      post_html_hidden_elements += "<input type='hidden' name='cc_holder[]' value='' >"
      post_html_hidden_elements += "<input type='hidden' name='cheque_no[]' value='' >"
      post_html_hidden_elements += "<input type='hidden' name='other_tran[]' value='' >"
      post_html_hidden_elements += "<input type='hidden' name='cc_month[]' value='' >"
      post_html_hidden_elements += "<input type='hidden' name='cc_year[]' value='' >"
      post_html_hidden_elements += "<input type='hidden' name='cc_type[]' value='' >"
      post_html_hidden_elements += "<input type='hidden' name='cc_cvv2[]' value='' >"
      post_html_hidden_elements += "<input type='hidden' name='payment_note[]' value='' >"
      post_html_hidden_elements += "<input type='hidden' name='cc_transac_no[]' value='' >"
    })// sorted items

    var main_order_total = parseFloat($('#total').text())
    
    // alert(parseFloat(localStorage.getItem('posdiscount')))
    var posdiscount = (total / main_order_total) * parseFloat(localStorage.getItem('posdiscount'))
    // alert(posdiscount);
    // Order level discount calculations
    if (posdiscount) {
      var ds = posdiscount.toString()
      if (ds.indexOf('%') !== -1) {
        var pds = ds.split('%')
        if (!isNaN(pds[0])) {
          order_discount = formatDecimal((parseFloat(((total) * parseFloat(pds[0])) / 100)), 4)
        } else {
          order_discount = parseFloat(ds)
        }
      } else {
        order_discount = parseFloat(ds)
      }
      // total_discount += parseFloat(order_discount);
    }

    // Order level tax calculations
    if (site.settings.tax2 != 0) {
      if (postax2 = localStorage.getItem('postax2')) {
        $.each(tax_rates, function () {
          if (this.id == postax2) {
            if (this.type == 2) {
              invoice_tax = formatDecimal(this.rate)
            }
            if (this.type == 1) {
              invoice_tax = formatDecimal((((total - order_discount) * this.rate) / 100), 4)
            }
          }
        })
      }
    }

    total = formatDecimal(total)
    product_tax = formatDecimal(product_tax)
    total_discount = formatDecimal(order_discount + product_discount)

    // Totals calculations after item addition
    var gtotal = parseFloat(((total + invoice_tax) - order_discount) + shipping)

    post_html_hidden_elements += "<input type='hidden' name='order_tax' value='1' >"
    post_html_hidden_elements += "<input type='hidden' name='discount' value='" + total_discount + "' >"
    post_html_hidden_elements += "<input type='hidden' name='total_items' value='" + sortedItems.length + "' >"
    post_html_hidden_elements += "<input type='hidden' name='paynear_mobile_app' value='' >"
    post_html_hidden_elements += "<input type='hidden' name='paynear_mobile_app_type' value='' >"
    post_html_hidden_elements += "<input type='hidden' name='submit_type' value='notprint' >"
    post_html_hidden_elements += "<input type='hidden' name='item_price' value='notprint' >"
    console.log(post_html_hidden_elements)

    /* if(set_item_name == 'split_order_1'){
      return true;
    } */
    $('form.dynamic_suspend_frm').remove()
    // alert($('form.dynamic_suspend_frm').html());
    $('<form class="dynamic_suspend_frm" action="pos/split_order_save">' + post_html_hidden_elements + '</form>').appendTo('body')

    return $.post('pos/split_order_save', $('.dynamic_suspend_frm').serialize()).done(function (data) {
      /* alert( "Data Loaded: " + data );
      console.log(data);
      document.location.href = "pos/index/"+data; */
      var split_orer_details = {
        'items': positems,
        'total': total,
        'product_tax': product_tax,
        'total_discount': total_discount,
        'gtotal': gtotal,
        'redirect_url': 'pos/index/' + data
      }
      console.log('----split order details-----')
      console.log(split_orer_details)

      $('form.dynamic_suspend_frm').empty()

      if (set_item_name == set_item_name) {
        
       

        /*if (btn_click_lable == 'Save & New') {
          // var data = JSON.parse('{}');
          // localStorage.setItem('positems',data);
          // localStorage.removeItem('positems');
          // clearItems();
          // loadItems();
          alert('Your split order saved in suspend successfully.')
        } else {
          $('.splitOrder .close').click() // close popup
        }
        if (btn_click_lable == 'Save & Print') {
          $('#print_bill').trigger('click')
          // var data = JSON.parse('{}');
          // localStorage.setItem('positems',data);
          localStorage.removeItem('positems')
          clearItems()
          // loadItems();
        }

        if (btn_click_lable == 'Checkout') {
          $('#payment').click()
        }
        if (btn_click_lable == 'Save') {
          // var data = JSON.parse('{}');
          // localStorage.setItem('positems',data);
          localStorage.removeItem('positems')
          clearItems()
          loadItems()
          alert('Your split orders are saved in suspend successfully. Thanks!')
        }*/
      }

      return data
    })

    $('form.dynamic_suspend_frm').empty()
  } else {
    alert('Items empty!')
  }
}

function add_split_order_pay_invoice_item (set_item_name, item) {
  // console.log(item);
  if (localStorage.getItem(set_item_name)) {
    var split_order_item = JSON.parse(localStorage.getItem(set_item_name))
  } else {
    var split_order_item = {}
  }

  if (item == null) { return }

  var item_id = site.settings.item_addition == 1 ? item.item_id : item.id
  if (item.options) {
    item_id = item_id + '' + item.row.option
  }

  // alert("Id----"+item_id);
  split_order_item[item_id] = item

  split_order_item[item_id].order = new Date().getTime()
  localStorage.setItem(set_item_name, JSON.stringify(split_order_item))
  // loadItems()
  return true
}



function split_order_pay () {
  localStorage.removeItem('order_num')
  //localStorage.removeItem('split_order_1')
  //localStorage.removeItem('split_order_2')



  if (localStorage.getItem('positems')) {
    var items = JSON.parse(localStorage.getItem('positems'))
    
    var split_num = prompt("Enter number of split order")
    if(split_num){
      for(var i=0;i<split_num;i++){
        localStorage.removeItem('split_order_'+i);
      }
    }else{
    return false;
    }
    
      $.each(items, function (key, item) {
        // alert($(option).val());
       
        //alert(parseFloat(item.row.price/split_num))
        item.row.qty = parseFloat(item.row.qty/split_num);
        //item.row.price = parseFloat(item.row.price/split_num)
        //item.row.base_unit_price = parseFloat(item.row.base_unit_price/split_num)
        //item.row.real_unit_price = parseFloat(item.row.real_unit_price/split_num)
        
        //items[key].row.price = parseFloat(items[key].row.price/split_num)
        for(var i=0;i<split_num;i++){
        add_split_order_pay_invoice_item('split_pay_order_'+i, item)
        
        }
      });
      localStorage.setItem('positems', localStorage.getItem('split_pay_order_0'))
      loadItems();
      $('#payment').click()
      //i=1 initialize by 1 due to 0 index loaded
      for(var i=1;i<split_num;i++){
        localStorage.setItem('positems', localStorage.getItem('split_pay_order_'+i))
        loadItems();
        var saved = 0;
      loadSplitOrderPayItems('split_pay_order_'+i, 'split_pay_order_'+i).then(function(data){
        saved =1;
      });
      alert(i+ " Order saved successfully.");
      }
    //add_split_order_invoice_item("localstoraekey",order_name);
    
  } else {
    alert('Cart Empty!')
    return false
  }
}
// Split order end
