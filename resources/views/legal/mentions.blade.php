@extends('layouts.app')
@section('title', 'Mentions légales')
@section('content')
<div class="container" style="padding:40px 0; max-width: 800px; margin: 0 auto;">
    <h1 style="text-align: center; margin-bottom: 40px; color: #1c2434;">Mentions légales</h1>

    <div style="line-height: 1.8; color: #555;">
        <h2 style="color: #c2601a; margin-top: 30px;">1. Éditeur du site</h2>
        <p><strong>RoukLegal</strong><br>
        Société : [Nom de votre société]<br>
        Forme juridique : [SAS/SARL/etc.]<br>
        Capital social : [Montant] €<br>
        RCS : [Ville] [Numéro]<br>
        SIRET : [Numéro]<br>
        Adresse : Calavi, Cotonou, Bénin<br>
        Téléphone :+229 0150434710<br>
        Email : contact@rouklegal.com<br>
        Directeur de la publication : [Nom du responsable]</p>

        <h2 style="color: #c2601a; margin-top: 30px;">2. Hébergement</h2>
        <p><strong>[Nom de l'hébergeur]</strong><br>
        Adresse : [Adresse de l'hébergeur]<br>
        Téléphone : [Numéro de téléphone]<br>
        Site web : [Site de l'hébergeur]</p>

        <h2 style="color: #c2601a; margin-top: 30px;">3. Propriété intellectuelle</h2>
        <p>L'ensemble du contenu de ce site (textes, images, graphismes, logos, icônes, sons, logiciels) est la propriété exclusive de RoukLegal ou de ses partenaires. Toute reproduction, distribution, modification ou exploitation, totale ou partielle, sans autorisation préalable et écrite de RoukLegal est strictement interdite.</p>

        <h2 style="color: #c2601a; margin-top: 30px;">4. Protection des données personnelles</h2>
        <p>Conformément à la loi n° 2018-493 du 20 juin 2018 relative à la protection des données à caractère personnel et au règlement européen RGPD (UE) 2016/679, RoukLegal s'engage à protéger la confidentialité des données personnelles de ses utilisateurs.</p>
        <p>Pour plus d'informations, consultez notre <a href="{{ route('legal.privacy') }}" style="color: #c2601a;">Politique de confidentialité</a>.</p>

        <h2 style="color: #c2601a; margin-top: 30px;">5. Cookies</h2>
        <p>Le site utilise des cookies pour améliorer l'expérience utilisateur. En naviguant sur ce site, vous acceptez l'utilisation de ces cookies. Vous pouvez à tout moment désactiver les cookies dans les paramètres de votre navigateur.</p>

        <h2 style="color: #c2601a; margin-top: 30px;">6. Responsabilité</h2>
        <p>RoukLegal s'efforce d'assurer l'exactitude des informations diffusées sur ce site, mais ne peut garantir l'absence d'erreurs. L'utilisateur utilise ce site sous sa seule responsabilité. RoukLegal ne saurait être tenu responsable des dommages directs ou indirects résultant de l'utilisation de ce site.</p>

        <h2 style="color: #c2601a; margin-top: 30px;">7. Liens hypertextes</h2>
        <p>Le site peut contenir des liens vers d'autres sites. RoukLegal n'exerce aucun contrôle sur ces sites et décline toute responsabilité quant à leur contenu ou à leur politique de confidentialité.</p>

        <h2 style="color: #c2601a; margin-top: 30px;">8. Droit applicable et juridiction</h2>
        <p>Les présentes mentions légales sont soumises au droit béninois. En cas de litige, les tribunaux de Cotonou seront seuls compétents.</p>

        <h2 style="color: #c2601a; margin-top: 30px;">9. Contact</h2>
        <p>Pour toute question concernant ces mentions légales, vous pouvez nous contacter :<br>
        Email : gazaliouroukayath@gmail.com<br>
        Téléphone : +229 0150434710<br>
        Adresse : Calavie, Cotonou, Bénin</p>

        <p style="margin-top: 40px; font-style: italic; text-align: center;">Dernière mise à jour : {{ date('d/m/Y') }}</p>
    </div>
</div>
@endsection
