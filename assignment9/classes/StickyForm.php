<?php
require_once 'Validation.php';

class StickyForm extends Validation {

    private $hasErrors = false;

    public function hasErrors() {
        return $this->hasErrors;
    }

    public function validateForm($data, $formConfig) {
        // ensure masterStatus exists
        if (!isset($formConfig['masterStatus'])) {
            $formConfig['masterStatus'] = ['error' => false, 'msg' => ''];
        }

        $this->hasErrors = false;

        foreach ($formConfig as $key => &$element) {
            if ($key === 'masterStatus' || !is_array($element)) { continue; }

            $element['value'] = $data[$key] ?? '';

            $customErrorMsg = $element['errorMsg'] ?? '';
            $required = !empty($element['required']);
            $value = trim((string)$element['value']);
            $rule  = $element['regex'] ?? null;

            if ($required && $value === '') {
                $element['error'] = $customErrorMsg ?: 'This field is required.';
                $formConfig['masterStatus']['error'] = true;
                $this->hasErrors = true;
                continue;
            }

            if ($value === '') { // optional empty is fine
                $element['error'] = '';
                continue;
            }

            //  checkFormat() booleans
            if ($rule === 'confirm_password') {
                $original = (string)($data['password'] ?? '');
                if ($value !== $original) {
                    $element['error'] = $customErrorMsg ?: 'Passwords do not match.';
                    $formConfig['masterStatus']['error'] = true;
                    $this->hasErrors = true;
                } else {
                    $element['error'] = '';
                }
            }
            else if ($rule) {
                $isValid = $this->checkFormat($value, $rule, $customErrorMsg);
                if (!$isValid) {
                    $element['error'] = $customErrorMsg ?: 'Invalid value.';
                    $formConfig['masterStatus']['error'] = true;
                    $this->hasErrors = true;
                } else {
                    $element['error'] = '';
                }
            } else {
                $element['error'] = '';
            }
        }
        unset($element);

        return $formConfig;
    }

    public function stickOrDefault(array $formConfig, string $key, string $default = ''): string {
    // 1) If the user typed something (sticky), show that
    $val = $formConfig[$key]['value'] ?? '';
    if ($val !== '') {
        return htmlspecialchars($val);
    }
    // 2) After a successful insert, suppress defaults (show empty)
    if (!empty($formConfig['suppressDefaults'])) {
        return '';
    }
    // 3) First page load: show the default
    return htmlspecialchars($default);
}



    public function renderUserTableRows($rows) : string {
    // Accepts: 'error', [], or array of assoc rows
    if ($rows === 'error') {
        return '<tr><td colspan="4" class="text-danger">Error loading records.</td></tr>';
    }
    if (empty($rows)) {
        return '<tr><td colspan="4">No records yet.</td></tr>';
    }

    $out = '';
    foreach ($rows as $r) {
        $fn = htmlspecialchars($r['user_firstname'] ?? '');
        $ln = htmlspecialchars($r['user_lastname'] ?? '');
        $em = htmlspecialchars($r['user_email'] ?? '');
        $ph = htmlspecialchars(substr((string)($r['user_passwordhash'] ?? ''), 0, 60)) ; //hash preview
        $out .= "<tr><td>{$fn}</td><td>{$ln}</td><td>{$em}</td><td>{$ph}</td></tr>";
    }
    return $out;
}

}
