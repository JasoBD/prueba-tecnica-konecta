
<button type="button" class="btn btn-primary show-modal-sale" data-toggle="modal"
        title="Haz click aqui para agregar un nuevo producto">
    Venta de producto
</button>
<br><br><br>

<table class="table  table-striped  table-hover" id="tabla">
    <thead>
    <tr>
        <th style="width:120px; background-color: #5DACCD; color:#fff">Id</th>
        <th style="width:180px; background-color: #5DACCD; color:#fff">Producto</th>
        <th style="width:60px; background-color: #5DACCD; color:#fff">Cantidad</th>
        <th style="width:60px; background-color: #5DACCD; color:#fff">Acciones</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($this->model->getList() as $r): ?>
        <tr>
            <td><?php echo $r->id; ?></td>
            <td><?php echo $r->name; ?></td>
            <td><?php echo $r->quantity; ?></td>

            <td>
                <a href="#" onclick="alertDeleteSale(<?php echo $r->id ?>)"
                   class="btn btn-danger btn-sm" title="Haz click aquí para eliminar" data-toggle="modal"><span
                            class="glyphicon glyphicon-trash">
                            </span> Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="saleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Nuevo Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" id="frmSale" autocomplete="off">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="id" name="id">
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" id="id_product" name="id_product"
                                   placeholder="Id del producto:"
                                   aria-label="Id del producto:">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="quantity" placeholder="Cantidad:"
                                   name="quantity" min="1"
                                   aria-label="Referencia:">
                        </div>
                    </div>
                    <br><br>
                    <div class="g-recaptcha" data-sitekey="6Ldrm1waAAAAACr71mcbJkp2Q0awOPblOR5jgBKR"
                         id="captcha2" data-callback="correctCaptcha" style="margin-left: 23%;"></div>
                    <div id="msg_error" class="alert alert-danger" role="alert" style="display: none"></div>
                    <br><br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" id="btn-save-update" class="btn btn-primary">Guardar</button>

                    </div>
            </form>
        </div>
    </div>
</div>



