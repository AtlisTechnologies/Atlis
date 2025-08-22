<?php
function update_contractor_contact(PDO $pdo, int $personId): void {
    // Fetch latest phone number
    $stmt = $pdo->prepare('SELECT phone_number FROM person_phones WHERE person_id = :pid ORDER BY date_updated DESC, id DESC LIMIT 1');
    $stmt->execute([':pid' => $personId]);
    $phone = $stmt->fetchColumn();

    // Fetch latest address
    $stmt = $pdo->prepare('SELECT address_line1, address_line2, city, state_id, postal_code, country FROM person_addresses WHERE person_id = :pid ORDER BY date_updated DESC, id DESC LIMIT 1');
    $stmt->execute([':pid' => $personId]);
    $addr = $stmt->fetch(PDO::FETCH_ASSOC);
    $address = null;
    if ($addr) {
        $parts = array_filter([
            $addr['address_line1'] ?? null,
            $addr['address_line2'] ?? null,
            $addr['city'] ?? null,
            $addr['state_id'] ?? null,
            $addr['postal_code'] ?? null,
            $addr['country'] ?? null,
        ]);
        $address = implode(', ', $parts);
    }

    $stmt = $pdo->prepare('UPDATE module_contractors SET contact_phone = :phone, contact_address = :addr WHERE person_id = :pid');
    $stmt->execute([':phone' => $phone, ':addr' => $address, ':pid' => $personId]);
}
?>
