(function(){
  function updateBadges(container){
    container.querySelectorAll('select').forEach(function(sel){
      var badge = sel.parentElement.querySelector('.lookup-badge');
      if(badge){
        var color = sel.options[sel.selectedIndex].dataset.color || 'secondary';
        badge.className = 'badge badge-phoenix fs-10 ms-1 lookup-badge badge-phoenix-' + color;
      }
    });
  }
  document.querySelectorAll('.address-item,.phone-item').forEach(updateBadges);
  document.addEventListener('change', function(e){
    if(e.target.matches('.address-type, .address-status, .phone-type, .phone-status')){
      var item = e.target.closest('.address-item, .phone-item');
      if(item) updateBadges(item);
    }
  });

  var addPhoneBtn = document.getElementById('add-phone');
  var phonesContainer = document.getElementById('phones-container');
  if(addPhoneBtn && phonesContainer){
    addPhoneBtn.addEventListener('click', function(){
      var tpl = document.getElementById('phone-template').innerHTML.replace(/__INDEX__/g, phonesContainer.querySelectorAll('.phone-item').length);
      var div = document.createElement('div');
      div.innerHTML = tpl.trim();
      var item = div.firstElementChild;
      phonesContainer.appendChild(item);
      updateBadges(item);
    });
    phonesContainer.addEventListener('click', function(e){
      if(e.target.classList.contains('remove-phone')){
        e.target.closest('.phone-item').remove();
      }
    });
  }

  var addAddressBtn = document.getElementById('add-address');
  var addressesContainer = document.getElementById('addresses-container');
  if(addAddressBtn && addressesContainer){
    addAddressBtn.addEventListener('click', function(){
      var tpl = document.getElementById('address-template').innerHTML.replace(/__INDEX__/g, addressesContainer.querySelectorAll('.address-item').length);
      var div = document.createElement('div');
      div.innerHTML = tpl.trim();
      var item = div.firstElementChild;
      addressesContainer.appendChild(item);
      updateBadges(item);
    });
    addressesContainer.addEventListener('click', function(e){
      if(e.target.classList.contains('remove-address')){
        e.target.closest('.address-item').remove();
      }
    });
    addressesContainer.addEventListener('change', function(e){
      if(e.target.classList.contains('postal-lookup')){
        var zip = e.target.value.trim();
        if(zip.length === 5){
          fetch('https://api.zippopotam.us/us/' + zip)
            .then(function(r){ return r.ok ? r.json() : null; })
            .then(function(data){
              if(!data) return;
              var item = e.target.closest('.address-item');
              var place = data.places && data.places[0];
              if(place){
                var cityInput = item.querySelector('.city-input');
                if(cityInput) cityInput.value = place['place name'];
                var abbr = place['state abbreviation'];
                var stateSelect = item.querySelector('.state-select');
                if(stateSelect){
                  stateSelect.value = '';
                  Array.from(stateSelect.options).forEach(function(opt){
                    if(opt.dataset.code === abbr){ stateSelect.value = opt.value; }
                  });
                }
              }
            });
        }
      }
    });
  }
})();
