<div class="row">
	<form class="col s12" method="post">
		<div class="row">
			<div class="input-field col s6">
				<i class="material-icons prefix">account_circle</i>
				<input id="reg-name" name="reg-name" type="text"
					class='<?= $form_data['reg-name']['class'] ?? 'validate' ?>'
					value='<?= $form_data['reg-name']['value'] ?? '' ?>'>
				<label for="reg-name">First Name</label>
				<?php if (isset($name_message)): ?>
					<span class="helper-text" data-error="<?= $name_message ?>"></span>
				<?php endif ?>
			</div>
			<div class="input-field col s6">
				<i class="material-icons prefix">badge</i>
				<input id="reg-lastname" name="reg-lastname" type="text"
					class="<?= $form_data['reg-lastname']['class'] ?? 'validate' ?>"
					value="<?= $form_data['reg-lastname']['value'] ?? '' ?>">
				<label for="reg-lastname">Last Name</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s6">
				<i class="material-icons prefix">mark_email_unread</i>
				<input id="reg-email" name="reg-email" type="email"
					class="<?= $form_data['reg-email']['class'] ?? 'validate' ?>"
					value="<?= $form_data['reg-email']['value'] ?? '' ?>">
				<label for="reg-email">Email</label>
			</div>
			<div class="input-field col s6">
				<i class="material-icons prefix">phone</i>
				<input id="reg-phone" name="reg-phone" type="tel"
					class="<?= $form_data['reg-phone']['class'] ?? 'validate' ?>"
					value="<?= $form_data['reg-phone']['value'] ?? '' ?>">
				<label for="reg-phone">Telephone</label>
			</div>
		</div>
		<div class="row center-align">
			<button class="waves-effect waves-light btn orange darken-3">
				<i class="material-icons right">how_to_reg</i>Register
			</button>
		</div>
	</form>
</div>
<p>
	Особливості роботи з формами полягають у тому, що оновлення
	сторінки можи привести до повторної передачі даних. У разі
	POST запиту про це видається попередження, у разі GET - повтор
	автоматичний. Рекомендовано роботу з формами розділяти на
	два етапи: 1) прийом і оброблення даних та 2) відображення.
	Між цими етапами сервер передає браузеру редирект і зберігає
	дані у сесії. При повторному запиті дані відновлюються і
	відображаються.
</p>