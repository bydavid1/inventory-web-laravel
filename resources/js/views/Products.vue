<template>
  <fragment>
    <div class="app-card">
      <div class="app-card-body">
        <div class="table-responsive">
          <datatable :columns="columns" :data="rows" class="table"></datatable>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </fragment>
</template>

<script>
export default {
    name: 'Products',
    data: function () {
      return {
        columns: [
          {label: 'id', field: 'user.id'},
          {label: 'Username', field: 'user.username', headerClass: 'class-in-header second-class'},
          {label: 'First Name', field: 'user.firstName'},
          {label: 'Last Name', field: 'user.lastName'},
          {label: 'Email', field: 'user.email'},
        ],
        rows: [
          {
            user: {
              id: 1,
              username: "dprice0",
              firstName: "Daniel",
              lastName: "Price",
              email: "dprice0@blogs.com"
            }
          }
        ]
      }
    }
}
</script>
