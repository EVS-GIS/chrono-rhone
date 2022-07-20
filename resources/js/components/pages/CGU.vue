<template>
  <section class="hero">
    <div class="hero-body">
      <h1 class="title has-text-centered">
        Conditions générales d'utilisation
      </h1>
      <h2 class="subtitle has-text-centered">
        Plateforme Chrono-Rhône
      </h2>
      <h3 class="subtitle has-text-centered">
        Préambule
      </h3>
      <div class="content has-text-justified">
        <p>
            Les présentes conditions générales d’utilisation (ci-après CGU) sont applicables à toute personne physique accédant directement au site internet https://chrono-rhone.ens-lyon.fr/, édité par le laboratoire Environnement, Ville, Société (EVS, UMR 5600), ci-après dénommé par « EVS ».
        </p>
        <p>
            EVS est un laboratoire dirigé par Etienne Cossart sous la cotutelle du Centre National de la Recherche Scientifique, l’Université Lumière Lyon 2, l’Université Jean Moulin Lyon 3, l’Université Jean Monnet Saint-Etienne, l’Ecole des Mines de Saint-Etienne, l’Ecole Normale Supérieure de Lyon, l’Ecole Nationale Supérieure d’Architecture de Lyon, l’Institut National des Sciences Appliquées de Lyon, et l’Ecole Nationale des Travaux Publics de l’Etat.
        </p>
        <p>
            EVS a développé une plateforme dénommée « CHRONO-RHONE », qui est une application web pour analyser et communiquer sur la trajectoire socio-environnementale du fleuve Rhône, organisée autour d’un concept de frise chrono-systémique et d’une interface cartographique. Cette application a été développée par Fanny Arnaud, Dad Roux-Michollet, Aurélie Antonio, Stéphanie Vukelic, Hervé Piégay et Samuel Dunesme, lesquels ont confié la valorisation de la plateforme à l’ENS de Lyon. Le code source a été développé par M. Ludovic Delhomme de la société Datayma, qui a cédé ses droits patrimoniaux aux établissements tutelles d’EVS.
        </p>
        <p>
            L’accès et l’utilisation de la PLATEFORME est gratuit mais nécessite l’acceptation expresse des CGU par l’utilisateur, c’est-à-dire toute personne physique qui accède à la PLATEFORME (ci-après l’« UTILISATEUR »).
        </p>
        <p>
            En conséquence, l’UTILISATEUR reconnait être parfaitement informé du fait que son accord concernant le contenu des CGU ne nécessite pas une signature manuscrite ou virtuelle de ce document, dans la mesure où il souhaite accéder en ligne à la PLATEFORME.
        </p>
        <p>
            Ces CGU peuvent faire l’objet, à tout moment, de modifications.
        </p>
        <p>
            Dès lors, il est entendu que les CGU applicables à l’accès à la PLATEFORME, sont celles en vigueur sur la PLATEFORME au moment de cet accès.
        </p>
        <p>
            La date de mise en ligne de ces CGU vaut date de mise en vigueur.
        </p>
        <p>
            Tout nouvel accès postérieur à l’entrée en vigueur de nouvelles CGU est donc soumis à ces nouvelles CGU.
        </p>
      </div>
      <h3 class="subtitle has-text-centered">
        Mentions légales
      </h3>
      <div class="content has-text-justified">
          <p><b>Editeur :</b> École normale supérieure de Lyon, 15 Parvis René Descartes, BP 7000, 69342 LYON cedex 07 (agissant au nom et pour le compte de EVS)</p>
          <p><b>Directeur de publication :</b> Jean-François Pinton, Président de l’ENS de Lyon</p>
          <p><b>Responsable scientifique de PLATEFORME :</b> Fanny Arnaud, fanny.arnaud@ens-lyon.fr</p>
          <p><b>Hébergeur :</b> ENS de Lyon</p>
          <p><b>Contact :</b> samuel.dunesme@ens-lyon.fr</p>
      </div>
      <h3 class="subtitle has-text-centered">
        1. Définitions
      </h3>

        <div class="columns is-mobile is-centered">
          <div class="column is-2">
            <a href="https://ohm-vallee-du-rhone.in2p3.fr" target="_blank">
              <img src="./../../assets/OHMVR.jpg" alt="OHM Vallée du Rhône"/>
            </a>
          </div>
          <div class="column is-2">
            <a href="https://umr5600.cnrs.fr" target="_blank">
              <img src="./../../assets/evs.jpg" alt="laboratoire EVS-ENS de Lyon"/>
            </a>
          </div>
          <div class="column is-2">
            <a href="https://datayama.fr" target="_blank">
              <img src="./../../assets/datayama.png" alt="Datayama"/>
            </a>
          </div>
        </div>
      </div>
    </div>
    <footer class="footer is-info">
      <div class="content has-text-centered">
        <p>Projet financé en 2020 par la SATT <a href="https://www.pulsalys.fr/" target="_blank">Pulsalys</a> de Lyon St-Etienne et <a href="https://idexlyon.universite-lyon.fr/" target="_blank">l’IDEX Université de Lyon</a>.</p>
      </div>
    </footer>
  </section>
</template>

<script>
import { mapState } from "vuex"
export default {
  name: "Home"
}
</script>

<style scoped>
.buttons:not(:last-child){
  margin:30px 0 0 0;
}
.footer {
  padding: 1rem !important;
  position: fixed;
  bottom: 0;
  width: 100%;
  overflow-x: hidden;
}
</style>

