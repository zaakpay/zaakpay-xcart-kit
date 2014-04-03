{*
$Id: cc_zaakpay.tpl,v 0.1 2012/07/24 02:30:00 zpay Exp $
vim: set ts=2 sw=2 sts=2 et:
*}
<h1>Zaakpay</h1>
{$lng.txt_cc_configure_top_text}
<br /><br />
{capture name=dialog}
<form action="cc_processing.php?cc_processor={$smarty.get.cc_processor|escape:"url"}" method="post">
<table cellspacing="10">
<tr>
<td>{$lng.lbl_cc_zaakpay_merchant_id}:</td>
<td><input type="text" name="param01" size="24" value="{$module_data.param01|escape}" /></td>
</tr>
<tr>
<td>{$lng.lbl_cc_zaakpay_secret_key}:</td>
<td><input type="text" name="param02" size="24" value="{$module_data.param02|escape}" /></td>
</tr>
<tr>
<td>{$lng.lbl_cc_zaakpay_mode}:</td>
<td>

<select name="param06">
<option value="TEST"{if $module_data.param06 eq "TEST"} selected="selected"{/if}>{$lng.lbl_cc_testlive_test}</option>
<option value="LIVE"{if $module_data.param06 eq "LIVE"} selected="selected"{/if}>{$lng.lbl_cc_testlive_live}</option>
</select>
</td>
</tr>

<tr>
<td>{$lng.lbl_cc_currency}:</td>
<td>
<select name="param05">
<option value="INR"{if $module_data.param05 eq "INR"} selected="selected"{/if}>Indian Rupee (India)</option>
</select>
</td>
</tr>

<tr>
<td>{$lng.lbl_cc_zaakpay_log}:</td>
<td>

<select name="param04">
<option value="YES"{if $module_data.param04 eq "YES"} selected="selected"{/if}>Yes</option>
<option value="NO"{if $module_data.param04 eq "NO"} selected="selected"{/if}>No</option>
</select>
</td>
</tr>

</table>
<br /><br />
<input type="submit" value="{$lng.lbl_update|strip_tags:false|escape}" />
</form>

<div style="padding: 0 20px">
  {$lng.txt_cc_authnet_tstamp_note}
</div>
{/capture}
{include file="dialog.tpl" title=$lng.lbl_cc_settings content=$smarty.capture.dialog extra='width="100%"'}