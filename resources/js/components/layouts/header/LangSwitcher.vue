<template>
  <b-navbar-dropdown :label="$t('nav.language')" collapsible>
    <b-navbar-item @click="switchLang('fr')">
      Fr
    </b-navbar-item>
    <b-navbar-item @click="switchLang('en')">
      En
    </b-navbar-item>
  </b-navbar-dropdown>
</template>

<script>
export default {
  name: 'LangSwitcher',
  methods: {
    switchLang(locale) {
      this.$i18n.locale = locale
    }
  }
}
</script>