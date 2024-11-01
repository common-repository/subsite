(function (document){

  document.addEventListener('DOMContentLoaded',
    () => {
      const extractSubsiteID = function () {

        let subsiteID = null;
        const bodyEl = document.querySelector('body');

        if (typeof(bodyEl.classList) != 'undefined' && bodyEl.classList.length > 0) {

          bodyEl.classList.forEach(
            (className) => {
              if (className.substring(0, 11) == 'subsite-') {
                subsiteID = parseInt(className.substring(11));
              }
            }
          );
        }

        return subsiteID;
      }

      const subsiteID = extractSubsiteID();

      if (subsiteID) {
        let searchForms = document.querySelectorAll('form[role="search"]');
        
        if (searchForms.length > 0) {
        
          // const newInput = document.createElement('input');

          // newInput.setAttribute('type', 'hidden');
          // newInput.setAttribute('value', subsiteID);
          // newInput.setAttribute('name', 'subsite_id');

          searchForms.forEach(
            (searchForm) => {
              const searchFormAction = searchForm.getAttribute('action');

              if (searchFormAction) {
                const qsDelimiter = searchFormAction.indexOf('?') !== -1 ? '&' : '?';

                //searchForm.appendChild(newInput);
                searchForm.setAttribute('action', searchFormAction.toString() + qsDelimiter + 'subsite_id=' + subsiteID);
              }
            }
          )
        }
      }
    }
  );

})(document);