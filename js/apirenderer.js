(function ($) {
  Drupal.behaviors.exampleModule = {
    attach: function (context, settings) {
      var $hash = window.location.hash;
      if ($hash) {
        $token = $hash.substring($hash.indexOf("=")+1);
        $('#edit-apirenderer-instagram-gallery-token').val($token);
        $('#edit-apirenderer-instagram-gallery-token').attr("readonly", true);
      }
      var $apirenderer_redirect = window.location.href;
      var $url = 'https://api.instagram.com/oauth/authorize/?client_id=db2711a5e6724f44953f440b25805369&redirect_uri=' + $apirenderer_redirect + '&response_type=token';
      $("a.APIRendererTokenLink").attr("href", $url);
    }
  };
}(jQuery));