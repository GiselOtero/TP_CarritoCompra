<?php
include_once("../../configuracion.php");
$Titulo = " Gestion de Productos";
include_once("../Estructura/header.php");

$datos = data_submitted();

$obj= new AbmProducto();
$listaProducto = $obj->buscar(null);

?>
<div>
    <h3 style="margin-left:1%">ABM - Productos</h3>
    <div class="row float-left">
        <div class="col-md-12 float-left">
          <?php 
          if(isset($datos) && isset($datos['msg']) && $datos['msg']!=null) {
            echo $datos['msg'];
          } 
         ?>
        </div>
    </div>
    
    
    <div class="row float-right">
    
        <div class="col-md-12 " style="margin-left:1%;margin-bottom:1%">
            <a href="javascript:void(0)" iconCls="icon-add" class="easyui-linkbutton" onclick="newProducto()">Nuevo</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" onclick="editProducto()">Editar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" onclick="destroyProducto()">Eliminar</a>
        </div>
       
    </div>
    
    <div id="wP" class="easyui-window" title="Producto nuevo:" data-options="closed:true, iconCls:'icon-add'" style="width:610px;height:200px;padding:10px;">
    
            <form class="fproducto" method="post" name="fproducto" id="fproducto" style="margin-left:30%;" novalidate>
                <input id="idproducto" name ="idproducto" type="hidden" value="<?php echo count($listaProducto) ?>" readonly data-options="required:true" >            
                
                <div class="row mb-3">
                    <div class="col-sm-6 ">
                        <div class="form-group has-feedback">
                            <label for="pronombre" class="control-label">Nombre Producto:</label>
                            <div class="input-group">
                            <input id="pronombre" name="pronombre" type="text" class="easyui-textbox" data-options="required:true" >
                            </div>
                        </div>
                    </div>
                </div>
    
            
                <div class="row mb-3">
                    <div class="col-sm-6 ">
                        <div class="form-group has-feedback">
                            <label for="prodetalle" class="control-label">Detalle:</label>
                            <div class="input-group">
                            <input id="prodetalle" name="prodetalle" type="text" class="easyui-textbox" required data-options="required:true">
                        </div>
                        </div>
                    </div>
                </div>
    
                <div class="row mb-3">
                    <div class="col-sm-6 ">
                        <div class="form-group has-feedback">
                            <label for="procantstock" class="control-label">Stock:</label>
                            <div class="input-group">
                            <input id="procantstock" name="procantstock" type="text" class="easyui-textbox"  required data-options="required:true">
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="row mb-3">
                    <div class="col-sm-6 ">
                        <div class="form-group has-feedback">
                            <label for="proimagen" class="control-label">Deshabilitado:</label>
                            <div class="input-group">
                            <input type="file" name="proimagen" id="proimagen">
                            </div>
                        </div>
                    </div>
                </div>
    
      
         
        <a href="javascript:void(0)" class="easyui-linkbutton" id="editarus" iconCls="icon-add" plain="true" onclick="saveProducto()">Confirmar </a>
    
        </form>
    
    
    </div>
    
      
    <table id="dg" name="dg" title="Lista de Productos" class="easyui-datagrid" style="width:700px;height:250px" url="listar.php" singleSelect="true">
            <thead>
                <tr>
                    <th field="idproducto" width="100">ID</th>
                    <th field="pronombre" width="200">Producto</th>
                    <th field="prodetalle" width="200">Detalle</th>
                    <th field="procantstock" width="200">Stock</th>
                </tr>
            </thead>
    </table> 
    
    <script type="text/javascript">
        var url;
        function newProducto(){
            $('#fproducto').form('clear');
            $('#wP').window('open');
            url = 'accion.php?accion=nuevo';
        }
    
        function editProducto(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#wP').dialog('open').dialog('center').dialog('setTitle','Editar Producto');
                $('#fproducto').form('load',row);
                url = 'accion.php?idproducto='+row.idProducto.'&accion="editar"';
            }
        }
    
        function saveProducto(){
            //alert(" Accion");
            var pass = $('#uspass').val();
            var passCod = md5(pass);
            $('#uspass').val(passCod);
            $('#fproducto').form('submit',{
                url: url,
                onSubmit: function(){
                return $(this).form('validate');
                },
                success: function(result){
                var result = eval('('+result+')');
    
                if (!result.respuesta){
                    $.messager.show({
                    title: 'Error',
                    msg: result.errorMsg
                });
                } else {
                        alert("Listo!");        
                        $('#wP').window('close');        // close the dialog
                        $('#dg').datagrid('reload');    // reload 
                        }
                    }
            });
        }
    
        function destroyProducto(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirm','Seguro que desea eliminar el Producto?', function(r){
                    if (r){
                        $.post('accion.php?idproducto='+row.idproducto.'&accion="eliminar"',
                        function(result){
                            if (result.respuesta){
                                alert("Listo!");   
                                $('#dg').datagrid('reload');    // reload the  data
                            } else {
                                $.messager.show({    // show error message
                                title: 'Error',
                                msg: result.errorMsg
                                });
                            }
                        },'json');
                    }
                });
            }
        }
    </script>

</div>
<?php
include_once "../Estructura/footer.php";
?>