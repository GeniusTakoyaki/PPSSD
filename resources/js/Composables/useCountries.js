import { ref, onMounted } from 'vue'
import axios from 'axios'

export default function useCountries() {
  const countries = ref([])

  const fetchCountries = async () => {
    const res = await axios.get('/api/countries')
    countries.value = res.data
  }

  onMounted(fetchCountries)

  return {
    countries
  }
}