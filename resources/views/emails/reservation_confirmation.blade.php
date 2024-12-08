<!-- resources/views/emails/reservation_confirmation.blade.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Réservation</title>
</head>
<body>
    <h1>Confirmation de votre réservation</h1>
    <p>Bonjour,</p>
    <p>Votre réservation pour la salle <strong>{{ $reservation->salle->nom }}</strong> a été confirmée.</p>
    <p><strong>Date de début :</strong> {{ $reservation->start_time }}</p>
    <p><strong>Date de fin :</strong> {{ $reservation->end_time }}</p>
    <p><strong>Préférences :</strong> {{ $reservation->preferences ?? 'Aucune' }}</p>
    <p><strong>Ressources :</strong> {{ $reservation->resources ?? 'Aucune' }}</p>
    <p>Merci de votre réservation!</p>
</body>
</html>
