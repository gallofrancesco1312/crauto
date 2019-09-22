<?php
/** @var $title string */
/** @var $error string|null */
/** @var $adminRequireOldPassword bool */
/** @var $attributes array */
/** @var $allowedAttributes array */
/** @var $editableAttributes string[] */
$this->layout('base');

$created = DateTime::createFromFormat( 'YmdHis\Z', $attributes['createtimestamp']);
$created = $created->format('Y-m-d H:i:s') . ' UTC';

$modified = DateTime::createFromFormat( 'YmdHis\Z', $attributes['modifytimestamp']);
$modified = $modified->format('Y-m-d H:i:s') . ' UTC';
?>

<h1><?= $title ?></h1>

<?php if($attributes['nsaccountlock'] === 'true'): ?>
	<div class="alert alert-warning" role="alert">
		🔒&nbsp;This account is locked
	</div>
<?php endif ?>

<?php if($error !== null): ?>
	<div class="alert alert-danger" role="alert">
		Error: <?= $this->e($error) ?>
	</div>
<?php endif ?>

<?= $this->fetch('userform', ['attributes' => $attributes, 'editableAttributes' => $editableAttributes, 'allowedAttributes' => $allowedAttributes]) ?>
<?= $this->fetch('authenticationform', ['requireOldPassword' => $adminRequireOldPassword]) ?>

<small>Created <?= $created ?> - Last modified <?= $modified ?></small>
