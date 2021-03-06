/*global wppfm_backup_list_form_vars */
function wppfm_resetBackupsList() {
	var backupListData    = null;
	var listHtml          = '';
	var backupListElement = jQuery( '#wppfm-backups-list' );

	wppfm_getBackupsList(
		function( list ) {
			if ( '0' !== list ) {
				backupListData = JSON.parse( list );

				// convert the data to html code
				listHtml = wppfm_backupsTable( backupListData );
			} else {
				listHtml = wppfm_emptyBackupsTable();
			}

			backupListElement.empty(); // first clear the feed list.

			backupListElement.append( listHtml );
		}
	);
}

/**
 * Restores the options on the settings page
 */
function wppfm_resetOptionSettings() {
	wppfm_getSettingsOptions(
		function( optionsString ) {

			if ( optionsString ) {
				var options = JSON.parse( optionsString );

				jQuery( '#wppfm_auto_feed_fix_mode' ).prop( 'checked', options[ 0 ] === 'true' );
				jQuery( '#wppfm_background_processing_mode' ).prop( 'checked', options[ 3 ] === 'true' );

				jQuery( '#wppfm_third_party_attr_keys' ).val( options[ 1 ] );
				jQuery( '#wppfm_notice_mailaddress' ).val( options[ 2 ] );
			}
		}
	);
}

function wppfm_backupsTable( list ) {
	var htmlCode = '';

	for ( var i = 0; i < list.length; i ++ ) {

		var backup   = list[ i ].split( '&&' );
		var fileName = backup[ 0 ];
		var fileDate = backup[ 1 ];

		htmlCode += '<tr id="feed-row"';
		if ( i % 2 === 0 ) {
			htmlCode += ' class="alternate"';
		} // alternate background color per row
		htmlCode += '>';
		htmlCode += '<td id="file-name" value="' + fileName + '">' + fileName + '</td>';
		htmlCode += '<td id="file-date">' + fileDate + '</td>';
		htmlCode += '<td id="actions"><strong><a href="javascript:void(0);" id="wppfm-delete-' + fileName.replace('.', '-') + '-backup-action" onclick="wppfm_deleteBackupFile(\'' + fileName + '\')">' + wppfm_backup_list_form_vars.list_delete + ' </a>';
		htmlCode += '| <a href="javascript:void(0);" id="wppfm-restore-' + fileName.replace('.', '-') + '-backup-action" onclick="wppfm_restoreBackupFile(\'' + fileName + '\')">' + wppfm_backup_list_form_vars.list_restore + ' </a>';
		htmlCode += '| <a href="javascript:void(0);" id="wppfm-duplicate-' + fileName.replace('.', '-') + '-backup-action" onclick="wppfm_duplicateBackupFile(\'' + fileName + '\')">' + wppfm_backup_list_form_vars.list_duplicate + ' </a></strong></td>';
		htmlCode += '</tr>';
	}

	return htmlCode;
}

function wppfm_emptyBackupsTable() {
	var htmlCode = '';

	htmlCode += '<tr>';
	htmlCode += '<td colspan = 4>' + wppfm_backup_list_form_vars.no_backup + '</td>';
	htmlCode += '</tr>';

	return htmlCode;
}

/**
 * Document ready actions
 */
jQuery(
	function() {
		// fill the backups list
		wppfm_resetBackupsList();
	}
);
