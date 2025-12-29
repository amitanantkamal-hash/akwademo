<script>
  const companyID = <?php echo auth()->user()->company_id; ?>;
  const setupDone = <?php echo $setupDone; ?>;
  var socialMedia = <?php echo '"' . $socialMedia . '"'; ?>;
  var alias = <?php echo '"' . $alias . '"'; ?>;
  var pageName = <?php echo '"' . $pageName . '"'; ?>;
  var modalItem;
  var meta;
  var loginMessage;
  var connectedPage;
  var logged = false;

  window.onload = (event) => {
    modalItem = new bootstrap.Modal(document.getElementById('metaModal'), {
      backdrop: 'static',
      keyboard: false
    });
  };

  window.fbAsyncInit = function() {
    FB.init({
      appId: <?php echo $socialMedia == 'instagram' ? env('INSTAGRAM_MESSAGES_APP_ID') : env('FACEBOOK_MESSAGES_APP_ID'); ?>,
      cookie: true,
      xfbml: true,
      version: 'v21.0'
    });
    FB.AppEvents.logPageView();
    FB.getLoginStatus(function(response) {
      var loginMessage = document.getElementById('loginMessage')
      alert(response.status === 'connected' && setupDone);
      if (response.status === 'connected' && setupDone) {
        loginMessage.innerHTML = '<p class="lead">Volver a vincular cuenta de ' +
          `${socialMedia}` + '</p>';
      } else {
        loginMessage.innerHTML = '<p class="lead">Vincule su cuenta de ' +
          `${socialMedia}` + '</p>';
      }
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
      return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  function statusChangeCallback(response, login = true) {
    logged = (response.status === 'connected' && setupDone);
    alert(response.status === 'connected' && setupDone);
    if (response.status === 'connected' && !login) {
      // Could login
      console.log('Logged');
      meta = {
        userID: response.authResponse.userID,
        token: response.authResponse.accessToken,
      }
      getPages();
    } else if (response.status != 'connected' && login) {
      // Always attempt to login on status check
      facebookLogin();
    } else {
      console.log('Not Logged')
    }
  }

  function logout() {
    try {
      FB.logout(function(response) {
        try {
          fetch('/api/meta/logout/' + alias, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
          }).then((response) => {
            // Check for successful response
            if (response.ok) {
              // Process the response body (usually in JSON format)
              return response.json(); // Parses the JSON response body
            } else {
              // Handle non-200 status codes (e.g., errors)
              throw new Error(`HTTP error! status: ${response.status}`);
            }
          }).then((response) => {
            statusChangeCallback(response);
            const hook = document.getElementById('alert-div');
            if (response && hook) {
              connectedPage = response.name;
              displayAlert(hook, {
                status: 'success',
                title: '¡Cuenta desvunculada!',
                message: 'Se ha removido ' + connectedPage + ' de Whatbox satisfactoriamente. '
              })
            }
          });
        } catch (error) {
          console.error('Error:', error);
        }
      });
    } catch (error) {
      console.error('Error:', error);
      displayAlert(hook, {
        status: 'error',
        title: '¡Error de conexión!',
        message: 'Se ha removido ' + connectedPage + ' de Whatbox satisfactoriamente. '
      })
    }
  }

  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  function getPages() {
    try {
      fetch('/api/meta/get-pages', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            userID: meta.userID,
            accessToken: meta.token,
            socialMedia: alias
          })
        }).then((response) => {
          // Check for successful response
          if (response.ok) {
            // Process the response body (usually in JSON format)
            return response.json(); // Parses the JSON response body
          } else {
            // Handle non-200 status codes (e.g., errors)
            throw new Error(`HTTP error! status: ${response.status}`);
          }
        })
        .then((data) => {
          console.log(data);
          openModal(data);
        })
        .catch((error) => {
          console.error('Error:', error);
        });
    } catch (error) {
      console.error('Error:', error);
    }
  }

  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  function facebookLogin() {
    FB.login(function(response) {
      statusChangeCallback(response, false)
    }, {
      scope: 'public_profile,email,pages_show_list,read_page_mailboxes,business_management,pages_messaging,pages_messaging_subscriptions,instagram_basic,instagram_manage_comments,instagram_manage_insights,instagram_content_publish,instagram_manage_messages,pages_read_engagement,pages_manage_metadata,instagram_branded_content_brand,instagram_manage_events',
      return_scopes: true,
      return_scopes_language: 'es_LA'
    });
  }

  function displayAlert(hook, alert = {
    status: false,
    title: '',
    message: ''
  }) {
    hook.innerHTML =
      (`<div class="alert alert-${alert.status}" role="alert"><strong>${alert.title}</strong>${alert.message}</div>`);
  }

  function alert(connected) {
    alertDiv = document.getElementById('alert-div');
    if (connected) {
      alertDiv.innerHTML = `<div class="alert alert-success" role="alert"><strong>¡Conectado!</strong> Su cuenta de ` +
        socialMedia + `: ${pageName}, ha sido vinculada con éxito.</div>`;

      badge.innerHTML = `<span class="badge badge-light-info me-auto">Conectado</span>`
    } else {
      alertDiv.innerHTML = `<div class="alert alert-danger" role="alert">` +
        `<strong>¡Sin conexión!</strong> ` +
        `Por favor, complete el inicio de sesión para conectar su cuenta de ` + socialMedia + `</div>`;
      badge.innerHTML = `<span class="badge badge-light-success me-auto">En progreso</span>`
    }
  }

  function openModal(data) {
    // const modalItem = document.getElementById('metaModal');
    const pageList = document.getElementById('pageList');
    pages = '';
    data.forEach(page => {
      pages +=
        `<div class="d-flex w-100 justify-content-between"><span>${page.name}</span><button type="button" class="btn btn-info" onclick="selectPage(${page.id})">Usar página</button></div>`
    });
    pageList.innerHTML = `<div class="d-flex flex-column gap-3 pr-3 pl-3">${pages}</div>`;

    modalItem.show();
  }

  function selectPage(pageId) {
    console.log(pageId)
    modalItem.hide();
    try {
      fetch('/api/meta/register-page', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          userID: meta.userID,
          pageID: pageId,
          companyID: companyID,
          accessToken: meta.token,
          socialMedia: alias
        })
      }).then((response) => {
        // Check for successful response
        if (response.ok) {
          // Process the response body (usually in JSON format)
          return response.json(); // Parses the JSON response body
        } else {
          // Handle non-200 status codes (e.g., errors)
          throw new Error(`HTTP error! status: ${response.status}`);
        }
      }).then((response) => {
        const hook = document.getElementById('alert-div');
        if (response && hook) {
          connectedPage = response;
          displayAlert(hook, {
            status: 'success',
            title: '¡Cuenta enlazada!',
            message: ' Haz conectado ' + connectedPage +
              ' con Whatbox satisfactoriamente. ' +
              ` Puede dirigirse al módulo de <a href="/chat">conversaciones</a> para gestionar mensajes de ${socialMedia}.`
          })
        }
      });
      alert(true);
    } catch (error) {
      console.error('Error:', error);
    }
  }

  function closeModal() {
    modalItem.hide();
  }
</script>
