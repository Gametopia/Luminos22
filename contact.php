<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $message = htmlspecialchars($_POST["message"]);

    // ✅ Zet hier jouw Slack webhook URL
    $webhook_url = "https://hooks.slack.com/services/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";

    $payload = json_encode([
        "text" => "📩 Nieuw bericht via contactformulier:\n\n*Naam:* $name\n*Email:* $email\n*Telefoonnummer:* $phone\n*Bericht:* $message"
    ]);

    $ch = curl_init($webhook_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Content-Length: " . strlen($payload)
    ]);

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Slack error"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request"]);
}
