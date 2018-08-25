<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<script src="<?=base_url()?>js/jquery.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/jquery-ui-1.9.2.custom.min.js"></script>

	<title>Prueba Desarrollo PlaceToPay</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
	<script type="text/javascript">
		/*
			validaBanco: función encargada de ejecutar el método crearTransaccion() siempre y cuando se cumpla
			la condición de que el banco seleccionado sea "BANCO UNION COLOMBIANO".
		 */
		function validaBanco(){
			
			idBanco = document.getElementById("bancos");
			idBanca = idBanco.options[idBanco.selectedIndex].value;

			interface = document.getElementById("interface");
			idInterface = interface.options[interface.selectedIndex].value;

			if(idBanca==1022){				
				var params={'bankCode':idBanca,'bankInterface':idInterface}; 
				$.ajax({
			      url: '<?=site_url('cliente/crearTransaccion')?>',
			      data: params,
			      type: "post",
			      dataType: "json",
			      success: function(datos){
			      	console.log(datos.createTransactionResult);
			      	var estado;
			      	estado = datos.createTransactionResult['returnCode'];
			      	if(estado=='SUCCESS'){			      		
			      		window.location.href = datos.createTransactionResult['bankURL'];
			      	}
			        
			      }
			    });

			}
			return;
		}
	</script>
</head>
<body style="background: #e8e7e7">

<div id="container">
	<div style="background: #373737">
		<div style="text-align: left;">
			<img title="PlaceToPay" src="<?=base_url()?>assets/logo.png" class="img-responsive" style="height: 45px;" />
		</div>
	</div>
	
	<div id="body">
		<h1>Bienvenido a la pasarela de Pagos!</h1>
		<span><strong>Indique el tipo de cuenta con la cual desea realizar el pago</strong></span>
		<br>
		<select name="interface" id="interface">
			<option value="0">Persona</option>
			<option value="1">Empresa</option>
		</select>
		<br>
		<span><strong>Seleccione de la lista la entidad fincanciera con la cual desea realizar el pago:</strong></span>
		<br>
		<select name="bancos" id="bancos" onchange="validaBanco()">
			<?php foreach ($getBankListResult as $key => $value):?>
				<?php foreach ($value as $clave => $valor):?>
						<option value="<?=$valor['bankCode']?>"><?=$valor['bankName']?></option>					
					<?php endforeach; ?>				
			<?php endforeach;?>
		</select>
	</div>

	<p class="footer">
		<div style="background: #373737">
			<div>
				<div id="pie">
					<img src="https://www.placetopay.com/web/sites/all/themes/dp8/logo.svg" width="120px" height="30px">
				</div>
			</div>
		</div>
		Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>
	</p>
</div>

</body>
</html>