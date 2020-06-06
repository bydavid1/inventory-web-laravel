<table class="table table-condensed" id="productTable">
    <thead>
        <tr class="info">
            <th style="width:10%;">Codigo</th>
            <th style="width:20%;">Producto</th>
            <th style="width:10%;">Precio</th>
            <th style="width:10%;">Cantidad</th>
            <th style="width:8%;">Importe</th>
            <th style="width:10%;">Total</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
                  $arrayNumber = 0;
                  for($x = 1; $x < 2; $x++) {
    ?>
        <tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">
            <input type="hidden" name="idvalue<?php echo $x; ?>" id="idvalue<?php echo $x; ?>"/>
            <td>
                <div class="form-group col-sm-12">
                    <input type="text" name="pcode<?php echo $x; ?>" id="pcode<?php echo $x; ?>"
                        autocomplete="off" class="form-control"
                        onchange='getProductData(<?php echo $x; ?>)' placeholder="Ingrese un codigo"/>
                        <input type="hidden" name="pcodevalue<?php echo $x; ?>" id="pcodevalue<?php echo $x; ?>">
                </div>
            </td>
            <td>
                <div class="form-group col-sm-12">
                    <input type="text" name="pname<?php echo $x; ?>" id="pname<?php echo $x; ?>"
                        autocomplete="off" class="form-control" disabled />
                        <input type="hidden" name="pnamevalue<?php echo $x; ?>" id="pnamevalue<?php echo $x; ?>">
                </div>
            </td>
            <td>
                <div class="input-group col-sm-12">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" name="price<?php echo $x; ?>" id="price<?php echo $x; ?>" autocomplete="off"
                        class="form-control" step='0.01' min='0' onchange='totalValue(<?php echo $x; ?>)'
                        disabled />
                        <input type="hidden" name="pricevalue<?php echo $x; ?>" id="pricevalue<?php echo $x; ?>">
                </div>
            </td>
            <td>
                <div class="form-group col-sm-12">
                    <input type="number" name="quantity<?php echo $x; ?>" id="quantity<?php echo $x; ?>" autocomplete="off"
                        class="form-control" min='1' onchange='totalValue(<?php echo $x; ?>)' disabled />
                        <input type="hidden" name="quantityvalue<?php echo $x; ?>" id="quantityvalue<?php echo $x; ?>">
                </div>
            </td>
            <td>
                <div class="form-group col-sm-12">
                    <input type="text" value="13%" class="form-control" disabled="true" />
                </div>
            </td>
            <td>
                <div class="input-group col-sm-12">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="text" name="total<?php echo $x; ?>" id="total<?php echo $x; ?>" autocomplete="off"
                        class="form-control" step='0.01' min='0' disabled="true" />
                        <input type="hidden" name="totalvalue<?php echo $x; ?>" id="totalvalue<?php echo $x; ?>">
                </div>
            </td>
            <td>
                <button class="btn btn-primary" type="button" id="removeProductRowBtn"
                    onclick="removeProductRow(<?php echo $x; ?>)"><i
                        class="fa fa-trash"></i></button>
            </td>
        </tr>
        <?php
  $arrayNumber++;
  }
  ?>
    </tbody>
</table>