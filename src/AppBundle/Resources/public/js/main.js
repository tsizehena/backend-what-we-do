/**
 * Created by mazaf on 05/05/17.
 */
$(document).ready(function() {
  //Community
  $('input.note_max').on('input', function(){
        var $noteRecord = $('span[id^="field_widget"][id$="_notes"] table tbody tr');
        var noteMaxValue = parseInt(this.value);
        var existNoteNumber = parseInt($noteRecord.length);

        if (noteMaxValue < 0) {
          this.value = 0;
        } else if (noteMaxValue > 10) {
          this.value = 10;
        }
        /*
        if (noteMaxValue > existNoteNumber) {
          $addNoteBtn = $('span[id^="field_actions"][id$="_notes"] a');
          for (var i = 0; i < (noteMaxValue - existNoteNumber); i++) {
            setTimeout($addNoteBtn.click(), 4000);
          }
        } else if (noteMaxValue < existNoteNumber) {
          var rankTrToRemove = existNoteNumber - 1;
          for (var i = 0; i < (existNoteNumber - noteMaxValue); i++) {
            if ($noteRecord.length > 0) {
              $noteRecord.get(rankTrToRemove).remove()
              rankTrToRemove--;
            }
          }
        }*/
  });
  addDeleteButton();

  $(document).on('click', 'a.delete-note', function() {
    $(this).parent().parent().remove();
    refreshNoteValue();
  });

  $(document).on('sonata.add_element', function() {
    addDeleteButton();
    refreshNoteValue();
  });

  function addDeleteButton() {
    var btnDeleteTpl = '<a href="#" class="btn btn-sm btn-default delete-note" title="Supprimer"> <i class="fa fa-times" aria-hidden="true"></i>Supprimer </a>';
    $('span[id^="field_widget"][id$="_notes"] table tbody tr td:last-child input').each(function(index, value) {
      $(this).replaceWith(btnDeleteTpl);
    });
  }

  function refreshNoteValue() {
    $('span[id^="field_widget"][id$="_notes"] table tbody tr td:first-child input').each(function(index, value) {
      $(this).val(index);
    });
  }
});


