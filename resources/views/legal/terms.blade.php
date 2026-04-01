@extends('layouts.app')
@section('title', 'Conditions d\'utilisation')
@section('content')
<div class="container" style="padding:40px 0; max-width: 800px; margin: 0 auto;">
    <h1 style="text-align: center; margin-bottom: 40px; color: #1c2434;">Conditions générales d'utilisation</h1>

    <div style="line-height: 1.8; color: #555;">
        <p style="margin-bottom: 20px;">Les présentes conditions générales d'utilisation (CGU) régissent l'utilisation de la plateforme RoukLegal. En accédant à notre site et en utilisant nos services, vous acceptez d'être lié par ces conditions.</p>

        <h2 style="color: #c2601a; margin-top: 30px;">1. Objet</h2>
        <p>RoukLegal est une plateforme digitale qui met en relation des clients avec des professionnels du droit (avocats, notaires, juristes) pour des consultations juridiques, des questions écrites et des rendez-vous physiques.</p>

        <h2 style="color: #c2601a; margin-top: 30px;">2. Conditions d'accès</h2>
        <p>L'accès à la plateforme est réservé aux personnes majeures et capables. Pour utiliser certains services, vous devez créer un compte et fournir des informations exactes.</p>

        <h2 style="color: #c2601a; margin-top: 30px;">3. Inscription et compte utilisateur</h2>
        <p>L'inscription est gratuite. Vous êtes responsable de la confidentialité de vos identifiants de connexion. Toute activité effectuée avec votre compte vous est imputable.</p>

        <h2 style="color: #c2601a; margin-top: 30px;">4. Services proposés</h2>
        <h3>4.1 Questions juridiques</h3>
        <p>Vous pouvez poser des questions écrites aux acteurs juridiques. Les réponses sont fournies dans les meilleurs délais.</p>

        <h3>4.2 Rendez-vous</h3>
        <p>Vous pouvez prendre rendez-vous avec un acteur juridique selon ses créneaux disponibles. Le paiement est effectué en ligne via notre partenaire sécurisé.</p>

        <h3>4.3 Messagerie</h3>
        <p>Un système de messagerie sécurisée permet les échanges confidentiels entre clients et acteurs juridiques.</p>

        <h3>4.4 Articles et ressources</h3>
        <p>Accès à une bibliothèque d'articles juridiques rédigés par nos experts.</p>

        <h2 style="color: #c2601a; margin-top: 30px;">5. Tarification et paiement</h2>
        <p>Certains services sont payants (rendez-vous : 10 000 FCFA). Le paiement est sécurisé et traité par notre partenaire PayGate. En cas d'annulation, un remboursement peut être demandé selon nos conditions.</p>

        <h2 style="color: #c2601a; margin-top: 30px;">6. Obligations des utilisateurs</h2>
        <p>Vous vous engagez à :</p>
        <ul style="margin-left: 20px;">
            <li>Fournir des informations exactes</li>
            <li>Utiliser la plateforme de manière loyale</li>
            <li>Respecter la confidentialité des échanges</li>
            <li>Ne pas porter atteinte aux droits des autres utilisateurs</li>
            <li>Ne pas utiliser la plateforme à des fins illégales</li>
        </ul>

        <h2 style="color: #c2601a; margin-top: 30px;">7. Responsabilités</h2>
        <h3>7.1 Responsabilité de RoukLegal</h3>
        <p>RoukLegal met tout en œuvre pour assurer le bon fonctionnement de la plateforme, mais ne peut garantir une disponibilité permanente. Nous déclinons toute responsabilité en cas d'interruption de service due à des causes extérieures.</p>

        <h3>7.2 Responsabilité des acteurs juridiques</h3>
        <p>Les acteurs juridiques sont responsables du contenu de leurs réponses et conseils. RoukLegal ne peut être tenu responsable des conseils donnés par les professionnels.</p>

        <h3>7.3 Responsabilité des clients</h3>
        <p>Vous êtes responsable de l'utilisation que vous faites des services et des conseils reçus.</p>

        <h2 style="color: #c2601a; margin-top: 30px;">8. Propriété intellectuelle</h2>
        <p>Le contenu de la plateforme (textes, logos, logiciels) est protégé par le droit d'auteur. Toute reproduction sans autorisation est interdite.</p>

        <h2 style="color: #c2601a; margin-top: 30px;">9. Protection des données</h2>
        <p>Vos données sont traitées conformément à notre <a href="{{ route('legal.privacy') }}" style="color: #c2601a;">Politique de confidentialité</a> et au RGPD.</p>

        <h2 style="color: #c2601a; margin-top: 30px;">10. Résiliation</h2>
        <p>RoukLegal se réserve le droit de suspendre ou résilier votre compte en cas de violation des présentes conditions. Vous pouvez également résilier votre compte à tout moment.</p>

        <h2 style="color: #c2601a; margin-top: 30px;">11. Modifications des conditions</h2>
        <p>RoukLegal se réserve le droit de modifier ces conditions. Les utilisateurs seront informés des changements majeurs.</p>

        <h2 style="color: #c2601a; margin-top: 30px;">12. Droit applicable et juridiction</h2>
        <p>Ces conditions sont soumises au droit béninois. En cas de litige, les tribunaux de Cotonou seront seuls compétents.</p>

        <h2 style="color: #c2601a; margin-top: 30px;">13. Contact</h2>
        <p>Pour toute question concernant ces conditions :</p>
        <p>Email : gazaliouroukayath@gmail.com<br>
        Adresse : [Votre adresse], Cotonou, Bénin</p>

        <p style="margin-top: 40px; font-style: italic; text-align: center;">Dernière mise à jour : {{ date('d/m/Y') }}</p>
    </div>
</div>
@endsection
