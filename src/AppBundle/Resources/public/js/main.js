/**
 * Created by mazaf on 05/05/17.
 */
$(document).ready(function() {
  var nbNoteMax = 11;
  var nbChoiceMax = 10;

  //Community
  addDeleteButton('all');

  $('div.form-community-wrapper form').on('submit', function(event) {
    var message = null;
    if(parseInt($('span[id^="field_widget"][id$="_notes"] table tbody tr').length) == 0) {
      event.preventDefault();
      message = 'Veuillez ajouter des notes';
    }

    if(parseInt($('span[id^="field_widget"][id$="_choices"] table tbody tr').length) == 0) {
      event.preventDefault();
      message = message == null ? '' : message + '<br/>';
      message += 'Veuillez ajouter des choix';
    }

    if(message != null) {
      $bs_alert_container = $('div.form-community-wrapper').parent().parent();
      bs_alert($bs_alert_container, 'alert-danger', message);
    }
  });

  $(document).on('click', 'a.delete-notes, a.delete-choices', function() {
    $(this).parent().parent().remove();

    if($(this).hasClass('delete-notes')) {
      refreshNoteValue();
      $('span[id^="field_actions"][id$="_notes"] a').show();
    } else if ($(this).hasClass('delete-choices')) {
      $('span[id^="field_actions"][id$="_choices"] a').show();
    }
  });

  $(document).on('sonata.add_element', function(event) {
    var targetId = event.target.id;
    console.log(targetId);
    if(targetId.endsWith('choices')) {
      addDeleteButton('choices');
      if(parseInt($('span[id^="field_widget"][id$="_choices"] table tbody tr').length) >= nbChoiceMax) {
        $('span[id^="field_actions"][id$="_choices"] a').hide();
      }
    } else if (targetId.endsWith('notes')) {
      addDeleteButton('notes');
      refreshNoteValue();
      if(parseInt($('span[id^="field_widget"][id$="_notes"] table tbody tr').length) >= nbNoteMax) {
        $('span[id^="field_actions"][id$="_notes"] a').hide();
      }
    }
  });
});


function addDeleteButton(type) {
  var btnDeleteTpl = '<a href="#" class="btn btn-sm btn-default delete-__TYPE__" title="Supprimer"> <i class="fa fa-times" aria-hidden="true"></i>Supprimer </a>';

  if(type == 'all' || type == 'notes') {
    var btnDeleteNote = btnDeleteTpl.replace('__TYPE__', 'notes');
    $('span[id^="field_widget"][id$="_notes"] table tbody tr td:last-child input').each(function (index, value) {
      $(this).replaceWith(btnDeleteNote);
    });
  }

  if(type == 'all' || type == 'choices') {
    var btnDeleteChoice = btnDeleteTpl.replace('__TYPE__', 'choices');
    $('span[id^="field_widget"][id$="_choices"] table tbody tr td:last-child input').each(function(index, value) {
      $(this).replaceWith(btnDeleteChoice);
    });
  }
}

function refreshNoteValue() {
  $('span[id^="field_widget"][id$="_notes"] table tbody tr td:first-child input').each(function(index, value) {
    $(this).val(index);
  });
}

function bs_alert($container, type, message, title) {
  var html='<div class="alert '+type+' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
  var $previousAlert = $container.find('.alert');

  if ($previousAlert.length > 0 ) {
    $previousAlert.remove();
  }
  if(typeof title!=='undefined' &&  title!==''){
    html+='<h4>'+title+'</h4>';
  }
  html+='<span>'+message+'</span></div>';
  $container.prepend(html);
  $('html,body').scrollTop(0);
}

String.prototype.endsWith = function (endString) {
  if(this && this.length) {
    result = new RegExp(endString + '$').test(this);
    return result;
  }
  return false;
}


