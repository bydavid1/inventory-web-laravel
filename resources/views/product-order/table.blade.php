 <table id="productTable" class="invoice-table">
     <thead>
         <tr>
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
             <input type="hidden" name="idvalue<?php echo $x; ?>" id="idvalue<?php echo $x; ?>" />
             <td>
                 <input type="text" name="pcode<?php echo $x; ?>" id="pcode<?php echo $x; ?>" class="invoice-control"
                     autocomplete="ñokiero:v" onchange='getProductData(<?php echo $x; ?>)' placeholder="Ingrese un codigo"/>
                     <div class="icon-container d-none" id="loader<?php echo $x; ?>">
                        <i class="loader"></i>
                      </div>
                 <input type="hidden" name="pcodevalue<?php echo $x; ?>" id="pcodevalue<?php echo $x; ?>"/>
             </td>
             <td>
                 <input type="text" name="pname<?php echo $x; ?>" id="pname<?php echo $x; ?>" class="invoice-control"
                     autocomplete="off" disabled />
                 <input type="hidden" name="pnamevalue<?php echo $x; ?>" id="pnamevalue<?php echo $x; ?>"/>
             </td>
             <td>
                 <input type="decimal" name="price<?php echo $x; ?>" id="price<?php echo $x; ?>" class="invoice-control"
                     autocomplete="off" step='0.01' min='0' onkeyup='setToValues(<?php echo $x; ?>)' disabled />
                 <input type="hidden" name="pricevalue<?php echo $x; ?>" id="pricevalue<?php echo $x; ?>"/>
             </td>
             <td>
                 <input type="number" name="quantity<?php echo $x; ?>" id="quantity<?php echo $x; ?>" class="invoice-control"
                      autocomplete="off" min='1' onkeyup='setToValues(<?php echo $x; ?>)' disabled />
                 <input type="hidden" name="quantityvalue<?php echo $x; ?>" id="quantityvalue<?php echo $x; ?>"/>
             </td>
             <td>
                 <input type="text" value="13%" disabled="true" class="invoice-control" />
             </td>
             <td>
                 <input type="decimal" name="total<?php echo $x; ?>" id="total<?php echo $x; ?>" class="invoice-control"
                     autocomplete="off" step='0.01' min='0' disabled="true" />
                 <input type="hidden" name="totalvalue<?php echo $x; ?>" id="totalvalue<?php echo $x; ?>"/>
             </td>
             <td class="text-center">
                 <a class="btn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="fa fa-trash text-primary"></i></a>
             </td>
         </tr>
         <?php
      $arrayNumber++;
      }
      ?>
     </tbody>
 </table>
