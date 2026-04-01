@extends('layouts.app')
@section('title', 'Politique de confidentialité')
@section('content')
<div class="container" style="padding:40px 0; max-width: 800px; margin: 0 auto;">
    <h1 style="text-align: center; margin-bottom: 40px; color: #1c2434;">Politique de confidentialité</h1>

    <div style="line-height: 1.8; color: #555;">
        <p style="margin-bottom: 20px;">Chez RoukLegal, la protection de vos données personnelles est une priorité. Cette politique de confidentialité explique comment nous collectons, utilisons, partageons et protégeons vos informations.</p>

        <h2 style="color: #c2601a; margin-top: 30px;">1. Collecte des données</h2>
        <p>Nous collectons les données suivantes :</p>
        <ul style="margin-left: 20px;">
            <li><strong>Données d'identification :</strong> nom, prénom, adresse email, numéro de téléphone</li>
            <li><strong>Données professionnelles :</strong> profession, spécialisation (pour les acteurs juridiques)</li>
            <li><strong>Données de navigation :</strong> adresse IP, cookies, pages visitées</li>
            <li><strong>Données de paiement :</strong> informations bancaires (traitées par notre partenaire de paiement sécurisé)</li>
        </ul>

        <h2 style="color: #c2601a; margin-top: 30px;">2. Utilisation des données</h2>
        <p>Vos données sont utilisées pour :</p>
        <ul style="margin-left: 20px;">
            <li>Fournir nos services (consultations juridiques, messagerie, rendez-vous)</li>
            <li>Gérer votre compte utilisateur</li>
            <li>Traiter les paiements</li>
            <li>Améliorer notre plateforme</li>
            <li>Vous envoyer des communications relatives à votre compte</li>
            <li>Respecter nos obligations légales</li>
        </ul>

        <h2 style="color: #c2601a; margin-top: 30px;">3. Partage des données</h2>
        <p>Nous ne vendons pas vos données personnelles. Nous les partageons uniquement dans les cas suivants :</p>
        <ul style="margin-left: 20px;">
            <li>Avec les acteurs juridiques pour fournir les services demandés</li>
            <li>Avec nos prestataires techniques (hébergement, paiement)</li>
            <li>Lorsque la loi l'exige</li>
            <li>Avec votre consentement explicite</li>
        </ul>

        <h2 style="color: #c2601a; margin-top: 30px;">4. Sécurité des données</h2>
        <p>Nous mettons en œuvre des mesures techniques et organisationnelles appropriées pour protéger vos données contre l'accès non autorisé, la perte, l'altération ou la divulgation.</p>

        <h2 style="color: #c2601a; margin-top: 30px;">5. Cookies</h2>
        <p>Notre site utilise des cookies pour :</p>
        <ul style="margin-left: 20px;">
            <li>Assurer le fonctionnement du site</li>
            <li>Analyser l'utilisation du site (Google Analytics)</li>
            <li>Personnaliser votre expérience</li>
        </ul>
        <p>Vous pouvez gérer vos préférences de cookies dans les paramètres de votre navigateur.</p>

        <h2 style="color: #c2601a; margin-top: 30px;">6. Durée de conservation</h2>
        <p>Vos données sont conservées pendant la durée nécessaire à la fourniture de nos services et au respect de nos obligations légales (généralement 5 ans après la fin de notre relation contractuelle).</p>

        <h2 style="color: #c2601a; margin-top: 30px;">7. Vos droits</h2>
        <p>Conformément au RGPD, vous disposez des droits suivants :</p>
        <ul style="margin-left: 20px;">
            <li>Droit d'accès à vos données</li>
            <li>Droit de rectification</li>
            <li>Droit à l'effacement</li>
            <li>Droit à la portabilité</li>
            <li>Droit d'opposition</li>
            <li>Droit à la limitation du traitement</li>
        </ul>
        <p>Pour exercer ces droits, contactez-nous à gazaliouroukayath@gmail.com</p>

        <h2 style="color: #c2601a; margin-top: 30px;">8. Contact</h2>
        <p>Pour toute question concernant cette politique de confidentialité :</p>
        <p>Email : gazaliouroukayath@gmail.com<br>
        Adresse : [Votre adresse], Cotonou, Bénin</p>

        <p style="margin-top: 40px; font-style: italic; text-align: center;">Dernière mise à jour : {{ date('d/m/Y') }}</p>
    </div>
</div>
@endsection
