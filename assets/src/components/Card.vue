<template>
    <div>
      <div>
        <table>
          <tbody>
            <template v-for="(value, key) in data" :key="key">
            <tr v-if="!excludedKeys || excludedKeys.indexOf(key) === -1">
              <td class="fUpper bolder">{{ translatedKey(key) }}</td>
              <td>
                <template v-if="Array.isArray(value)">
                  <p v-for="item in value" :key="item" class="noMarge size-middle center">{{ item }}</p>
                </template>
                <template v-else>
                  <template v-if="isSpecialKey(key)">{{ formatDate(value) }}</template>
                  <template v-else>{{ value }}</template>
                </template>
              </td>
            </tr>
          </template>
          </tbody>
        </table>
      </div>
    </div>
  </template>
  
  <script>
  import { format } from 'date-fns';
  export default {
    name: "Card",
    props: {
      data: Object,
      excludedKeys: Array
    },
    methods: {
        translatedKey(key) {
            const translations = {
                name: 'nom',
                surname: 'prénom',
                birthDate: 'date de naissance',
                address: 'adresse',
                address_2: 'adresse complémentaire',
                city: 'ville',
                postalCode: 'code postal',
                country: 'pays',
                createdAt: 'créé le',
                updatedAt: 'mis à jour le',
                dateDebut: 'date de commencement',
                dateFin: 'date de fin',
                dateTirage: 'date du tirage',
                probability: 'probabilité'
            };
        return translations[key] || key;
    },
    formatDate(dateString) {
        var dateObject = new Date(dateString);
        var day = dateObject.getDate();
        var month = dateObject.getMonth() + 1;
        var year = dateObject.getFullYear();

        var formattedDay = (day < 10 ? '0' : '') + day;
        var formattedMonth = (month < 10 ? '0' : '') + month;

        var formattedDate = formattedDay + '/' + formattedMonth + '/' + year;
        return formattedDate;
    },
    isSpecialKey(key) {
        const specialKeys = ["updatedAt", "createdAt", "birthDate", "dateDebut", "dateFin", "dateTirage"];
        return specialKeys.includes(key);
    }
    }
  };
  </script>