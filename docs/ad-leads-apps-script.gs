/**
 * Amatchless Ad Leads Tracker: receives each landing page lead from amatchless.com and adds it as a row.
 *
 * Setup (once):
 *  1. Open the "Amatchless Ad Leads Tracker" sheet → Extensions → Apps Script. Delete what's there, paste this file.
 *  2. Change SECRET below to a long random value (letters and numbers). Save.
 *  3. Deploy → New deployment → type "Web app". Execute as: Me. Who has access: Anyone. Deploy, allow access.
 *  4. Copy the Web app URL (ends in /exec). In wp-admin → Settings → Ad leads, paste it as "Google Sheet web app URL"
 *     and paste the SECRET as "Google Sheet shared secret". Save, then click "Send a test row".
 *
 * The script matches values to the sheet's own header names, so columns can be moved. Tracking columns the sheet
 * doesn't have yet (utm_source, fbclid, …) are added at the right-hand end the first time a lead needs them.
 */
var SECRET = 'CHANGE-ME-to-a-long-random-value';
var SHEET_NAME = ''; // empty = the first tab

function doPost(e) {
  var lock = LockService.getScriptLock();
  try {
    var body = JSON.parse(e.postData.contents || '{}');
    if (!body.secret || body.secret !== SECRET) return reply({ ok: false, error: 'bad secret' });
    var row = body.row || {};
    lock.waitLock(20000);

    var ss = SpreadsheetApp.getActiveSpreadsheet();
    var sh = SHEET_NAME ? ss.getSheetByName(SHEET_NAME) : ss.getSheets()[0];
    var lastCol = Math.max(sh.getLastColumn(), 1);
    var headers = sh.getRange(1, 1, 1, lastCol).getValues()[0].map(function (h) { return String(h).trim(); });

    // Add any missing columns at the end.
    Object.keys(row).forEach(function (k) {
      if (headers.indexOf(k) === -1) {
        headers.push(k);
        sh.getRange(1, headers.length).setValue(k);
      }
    });

    var values = headers.map(function (h) {
      var v = row.hasOwnProperty(h) ? String(row[h]) : '';
      // Stop Sheets from reading "+91 …" or "=…" as a formula or a number.
      return /^[=+\-@]/.test(v) ? "'" + v : v;
    });
    sh.appendRow(values);
    return reply({ ok: true });
  } catch (err) {
    return reply({ ok: false, error: String(err) });
  } finally {
    try { lock.releaseLock(); } catch (x) {}
  }
}

function reply(obj) {
  return ContentService.createTextOutput(JSON.stringify(obj)).setMimeType(ContentService.MimeType.JSON);
}
