<!-- Add products modal-->
<div class="modal fade" tabindex="-1" role="dialog" id="addProductsModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i>Lista de productos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table" id="items">
					<thead>
						<tr>
							<th style="width:10%;">Imagen</th>						
							<th>Codigo</th>
							<th>Producto</th>							
                            <th>Precio</th>
                            <th>Cantidad</th>
							<th>Proveedor</th>
							<th>Categoria</th>
							<th style="width:15%;" class="text-right">Agregar</th>
						</tr>
					</thead>
				</table>
			</div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->