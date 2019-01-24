<!doctype html>
<title>Styde - En Mantenimiento</title>
<style>
  body { text-align: center; padding: 150px; }
  h1 { font-size: 50px; }
  body { font: 20px Helvetica, sans-serif; color: #333; }
  article { display: block; text-align: left; width: 650px; margin: 0 auto; }

  #bg_image {
      position: fixed;
      left: 0;
      right: 0;
      top: 0;
      z-index: 1;

      background-image:url({{url('img/background.jpg')}});
      width: 100%;
      height: 100%;

      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;

      -webkit-filter: blur(12px);
      -moz-filter: blur(12px);
      -o-filter: blur(12px);
      -ms-filter: blur(12px);
      filter: blur(12px);

  }

  #content_page{
      position: fixed;
      left: 0;
      right: 0;
      z-index: 9999;
      margin-left: 20px;
      margin-right: 20px;
      color: white;
  }
</style>

<article>
    <div id = "bg_image"></div>
    <div id="content_page" align="center">
        <img src={{ asset('img/logo.png') }} class="rounded mx-auto d-block">
        <h1>Mantenimiento</h1>
        <div>
            <p>Pedimos disculpas por los incovenientes, se están realizando operaciones de mantenimiento.</p>
            <p>&mdash; Departamento de Informática</p>
        </div>
    </div>
</article>
