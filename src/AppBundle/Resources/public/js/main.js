/**
 * Created by mazaf on 05/05/17.
 */
$(document).ready(function() {
  var action_free = true;
  //Community
  $('input.note_max').on('input', function(){
    if (action_free) {
      action_free = false;
      var noteMaxValue = parseInt(this.value);
      if (noteMaxValue < 0) {
        this.value = 0;
      } else if (noteMaxValue > 10) {
        this.value = 10;
      }
      var $noteRecord = $('span[id^="field_widget"][id$="_notes"] table tbody tr');
      var existNoteNumber = parseInt($noteRecord.length);

      if (noteMaxValue > existNoteNumber) {
        $addNoteBtn = $('span[id^="field_actions"][id$="_notes"] a');
        for (var i = 0; i < (noteMaxValue - existNoteNumber); i++) {
          console.log('add form');
          $addNoteBtn.click();
        }
      } else if (noteMaxValue < existNoteNumber) {
        var rankTrToRemove = existNoteNumber - 1;
        for (var i = 0; i < (existNoteNumber - noteMaxValue); i++) {
          if ($noteRecord.length > 0) {
            $noteRecord.get(rankTrToRemove).remove()
            rankTrToRemove--;
          }
        }
      }
      action_free = true;
    } else {
      this.value = $('span[id^="field_widget"][id$="_notes"] table tbody tr').length;
    }
  });
})
