<div class="pro-info"></div>
<form action="" method="post" enctype="multipart/form-data" id="form-profesional" name="submitform">
    <section class="site" data-site="professional_list">

    	<div class="container">


        <div class="row">
					<div class="col-sm-12">
						<div class="big-title">Listado de profesionales</div>
						<div class="space-height" style="height: 30px;"></div>
					</div>
				</div>

        <div class="container">
          <div class="cat-select">
            <div class="row">
              <div class="col-xs-12 col-sm-3 col-md-3">
                <div class="box-sec" data-level="1"></div>
              </div>
              <div class="col-xs-12 col-sm-3 col-md-3">
                <div class="box-sec" data-level="2"></div>
              </div>
              <div class="col-xs-12 col-sm-3 col-md-3">
                <div class="box-sec" data-level="3"></div>
              </div>
              <div class="col-xs-12 col-sm-3 col-md-3">
                <div class="box-sec" data-level="4"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <input class="button-continue center-block" type="submit" value="Buscar">
          </div>
          <hr>
          <div class="space-height" style="height: 30px;"></div>
        </div>

        <div class="row">
          <hr>
          <div class="space-height" style="height: 30px;"></div>
        </div>

        <div class="row">
          <button type="button" class="button-continue" style="width:auto;" aria-label="Left Align">
            <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
          </button>
          <div class="space-height" style="height: 30px;"></div>
        </div>

        <div class="row professionals">
          <?php echo show_professional(1, 'Nombre', 'Localidad', 'Dirección', 'Telefono', 'Horarios'); ?>
        </div>
      </div>
    </section>
  </form>

<style>
	@media(min-width:768px) {
		#add-another {
			margin:0px;
		}
	}
	@media(max-width:767px) {
		.cat-select .box-sec {
			margin-top:10px;
		}
		#add-another {
			margin:20px;
		}
	}
  .addlink{
    font-size: 18px;
    font-weight: bold;
    color: #ff6600;
  }
  .addedprofessional{
    font-size: 14px;
    font-weight: 700;
    color: #ff6600;
  }
  .professional{
    font-size: 14px;
    font-weight: 700;
  }
  .hrprofessional{
    background-color: dimgrey;
    height: 1;
    padding: 0;
  }
</style>