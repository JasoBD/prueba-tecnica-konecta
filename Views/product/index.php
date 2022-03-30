<!-- Button trigger modal -->
<button type="button" class="btn btn-primary show-modal-product" onclick="showModalProduct()"
        title="Haz click aqui para agregar un nuevo producto">
    Agregar producto
</button>

<br><br><br>
<table id="tabla" class="display tabla" style="width:100%">
    <thead>
    <tr>
        <th style=" background-color: #5DACCD; color:#fff">Id</th>
        <th style="background-color: #5DACCD; color:#fff">Nombre</th>
        <th style=" background-color: #5DACCD; color:#fff">Referencia</th>
        <th style=" background-color: #5DACCD; color:#fff">Precio</th>
        <th style=" background-color: #5DACCD; color:#fff">Peso</th>
        <th style=" background-color: #5DACCD; color:#fff">Categoria</th>
        <th style=" background-color: #5DACCD; color:#fff">Stock</th>
        <th style=" background-color: #5DACCD; color:#fff">Fecha de creaacion</th>
        <th style=" background-color: #5DACCD; color:#fff">Acciones</th>

    </tr>
    </thead>
    <tbody>
    <?php foreach ($this->model->getList() as $r): ?>
        <tr>
            <td><?php echo $r->id; ?></td>
            <td><?php echo $r->name; ?></td>
            <td><?php echo $r->reference; ?></td>
            <td><?php echo $r->price; ?></td>
            <td><?php echo $r->weight; ?></td>
            <td><?php echo $r->category; ?></td>
            <td><?php echo $r->stock; ?></td>
            <td><?php echo $r->created_at; ?></td>

            <td>
                <button type="button" data-id="<?php echo $r->id ?>" data-toggle="modal"
                        data-target=".editarModal-<?php echo $r->id ?>"
                        class="btn btn-success btn-sm editBtn show-modal-product"
                        title="Haz click aquí para editar">
                    <span class="glyphicon glyphicon-edit"></span> Editar
                </button>

                <a href="#" onclick="alertDeleteProduct(<?php echo $r->id ?>)"
                   class="btn btn-danger btn-sm" title="Haz click aquí para eliminar" data-toggle="modal"><span
                            class="glyphicon glyphicon-trash">
                            </span> Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<!--
Modal -->
<div id="content-data-table"></div>
<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Nuevo Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" id="frmProduct"  autocomplete="off">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="id" name="id">
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Nombre de producto:"
                                   aria-label="Nombre de producto:">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="reference" placeholder="Referencia:"
                                   name="reference"
                                   aria-label="Referencia:">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <input type="number" class="form-control" id="price" placeholder="Precio:" name="price"
                                   aria-label="Precio:">
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" id="weight" placeholder="Peso:" name="weight"
                                   aria-label="Peso:">
                        </div>
                    </div>
                    <br>
                    <div class="row ">
                        <div class="col">
                            <input type="text" class="form-control" id="category" placeholder="Categoría:"
                                   name="category"
                                   aria-label="Categoría:">
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" id="stock" placeholder="Stock" name="stock"
                                   min="1"  aria-label="Stock">
                        </div>
                    </div>
                    <br><br>
                    <div class="g-recaptcha" data-sitekey="6Ldrm1waAAAAACr71mcbJkp2Q0awOPblOR5jgBKR"
                         id="captcha2" data-callback="correctCaptcha" style="margin-left: 23%;"></div>
                    <div id="msg_error" class="alert alert-danger" role="alert" style="display: none"></div>
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" id="btn-save-update" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>




