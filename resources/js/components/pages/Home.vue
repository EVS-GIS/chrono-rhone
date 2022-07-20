<template>
  <section class="hero">
    <div class="hero-body">
      <h1 class="title has-text-centered">
        Chrono-Rhône
      </h1>
      <h2 class="subtitle has-text-centered">
        Une application spatio-temporelle interactive et collaborative sur le fleuve Rhône.
      </h2>
      <div class="content has-text-centered">
        <div class="buttons is-centered">
          <b-button size="is-medium" tag="router-link" :to="{ name: 'TimelinePage' }" type="is-info">Parcourez la frise</b-button>
        </div>
        <p>pour découvrir les événements historiques qui ont marqué l’évolution socio-environnementale du fleuve.</p>
        <div class="buttons is-centered">
          <b-button size="is-medium" tag="router-link" :to="{ name: 'Map' }" type="is-info">Parcourez la carte</b-button>
        </div>
        <p>qui spatialise les événements pour explorer les changements survenus sur votre territoire.</p>
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
        <p class="content has-text-centered">Chrono-Rhône est un prototype développé dans <a href="https://ohm-vallee-du-rhone.in2p3.fr" target="_blank">l’Observatoire Hommes-Milieux Vallée du Rhône</a>,
        à l’initiative du <a href="https://umr5600.cnrs.fr" target="_blank">laboratoire EVS-ENS de Lyon</a> 
        en collaboration avec la société <a href="https://datayama.fr" target="_blank">Datayama</a>.</p>
      </div>
    </div>
    <footer class="footer is-info">
      <div class="content has-text-centered">
        <p>Projet financé en 2020 par la SATT <a href="https://www.pulsalys.fr/" target="_blank">Pulsalys</a> de Lyon St-Etienne et <a href="https://idexlyon.universite-lyon.fr/" target="_blank">l’IDEX Université de Lyon</a>.</p>
      </div>
      <div class="content has-text-centered">
        <p>Lire les <a href="./cgu">conditions générales d'utilisation</a>.</p>
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

