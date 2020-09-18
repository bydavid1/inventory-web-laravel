export default {
    name : 'Item'
}

Vue.component('Item', {
    data () {
        return {

        }
    },
    props : {
        item : {
            type : Object,
            required : true
        }
    },
    template : 
/*html*/`<div class="invoice-product-details ">
    <form class="form invoice-item-repeater">
      <div data-repeater-list="group-a">
        <div data-repeater-item>
          <div class="row mb-50">
            <div class="col-3 col-md-4 invoice-item-title">Item</div>
            <div class="col-3 invoice-item-title">Precio</div>
            <div class="col-3 invoice-item-title">Cant</div>
            <div class="col-3 col-md-2 invoice-item-title">Total</div>
          </div>
          <div class="invoice-item d-flex border rounded mb-1">
            <div class="invoice-item-filed row pt-1 px-1">
              <div class="col-12 col-md-4 form-group">
                <input type="text" class="form-control" v-model="item.name" placeholder="0">
              </div>
              <div class="col-md-3 col-12 form-group">
                <input type="text" class="form-control" v-model="item.price" placeholder="0">
              </div>
              <div class="col-md-3 col-12 form-group">
                <input type="text" class="form-control" v-model="item.quantity" placeholder="0">
              </div>
              <div class="col-md-2 col-12 form-group">
                <strong class="text-primary align-middle">{{ item.total }}</strong>
              </div>
              <div class="col-md-4 col-12 form-group">
                <input type="text" class="form-control invoice-item-desc" v-model="item.description">
              </div>
              <div class="col-md-8 col-12 form-group">
                <span>Discount: </span><span class="discount-value mr-1">0%</span>
                <span class="mr-1 tax1">0%</span>
                <span class="mr-1 tax2">0%</span>
              </div>
            </div>
            <div class="invoice-icon d-flex flex-column justify-content-between border-left p-25">
              <span class="cursor-pointer" data-repeater-delete>
                <i class="bx bx-x"></i>
              </span>
              <div class="dropdown">
                <i class="bx bx-cog cursor-pointer dropdown-toggle" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false" role="button"></i>
                <div class="dropdown-menu p-1">
                  <div class="row">
                    <div class="col-12 form-group">
                      <label for="discount">Discount(%)</label>
                      <input type="number" class="form-control" id="discount" placeholder="0">
                    </div>
                    <div class="col-6 form-group">
                      <label for="Tax1">Tax1</label>
                      <select name="tax1" id="Tax1" class="form-control invoice-tax">
                        <option selected>1%</option>
                        <option>10%</option>
                        <option>18%</option>
                        <option>40%</option>
                      </select>
                    </div>
                    <div class="col-6 form-group">
                      <label for="Tax2">Tax2</label>
                      <select name="tax1" id="Tax2" class="form-control invoice-tax">
                        <option selected>1%</option>
                        <option>10%</option>
                        <option>18%</option>
                        <option>40%</option>
                      </select>
                    </div>
                  </div>
                  <hr>
                  <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-primary invoice-apply-btn" data-dismiss="modal">
                      <span>Apply</span>
                    </button>
                    <button type="button" class="btn btn-light-primary ml-1" data-dismiss="modal">
                      <span>Cancel</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>`
})