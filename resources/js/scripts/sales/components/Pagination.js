export default {
    name : 'Pagination'
}

Vue.component('Pagination',{
  template: 
/*html*/`<nav>
            <ul class="pagination justify-content-center">
                <li :class="{'disabled' : data.current_page <= 1}" class="page-item previous">
                    <a href="#" class="page-link" aria-label="Previous" @click.prevent="changePage(data.current_page - 1)">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>
                <li v-for="page in pagesNumber" :class="{\'active\': page == data.current_page, 'page-item' : 'page-item'}">
                    <a href="#" class="page-link" @click.prevent="changePage(page)">{{ page }}</a>
                </li>
                <li :class="{'disabled' : data.current_page >= data.last_page}"  class="page-item next">
                    <a href="#" class="page-link" aria-label="Next" @click.prevent="changePage(data.current_page + 1)">
                        <span aria-hidden="true">»</span>
                    </a> 
                </li> 
            </ul> 
        </nav>`,
  props: {
      data : {
          type : Object,
          required :true
      }
  },  
  data: function() {
    return {
      offset: 4,
    }
  },
  computed: {
        isActived: function () {
            return this.data.current_page;
        },
        pagesNumber: function () {
            if (!this.data.to) {
                return [];
            }
            var from = this.data.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.data.last_page) {
                to = this.data.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }
    },
  methods : {
    changePage: function (page) {
        this.$emit('change', page)
    }      
  }

})