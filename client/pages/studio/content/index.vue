<template>
   <article class="w-full bg-gray-100 pl-10 h-full border-t border-gray-300 border-solid mt-2 ml-4">
    <p class="text-2xl font-semibold my-6">Channel content</p>
    <div class="bg-white">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
          <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                      <th scope="col" class="px-6 py-3">
                          Video
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Visibility 
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Date
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Views
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Like
                      </th>
                      <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Edit</span>
                </th>
                  </tr>
              </thead>
              <tbody>
                   <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                      <th scope="row" class="pl-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                          <img class="w-40" src="https://culture.ec.europa.eu/sites/default/files/styles/eac_ratio_16_9_xl/public/2020-08/header-sector-ccs.jpg?h=9ffb04cf&itok=LMbsYP9x" alt="">
                      </th>
                      <td class="px-6 py-4">
                          White
                      </td>
                      <td class="px-6 py-4">
                          Laptop PC
                      </td>
                      <td class="px-6 py-4">
                          $1999
                      </td>
                      <td class="px-6 py-4">
                          99
                      </td>
                      <td class="px-6 py-4 text-right">
                          <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                      </td>
                  </tr>
                   <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                      <th scope="row" class="pl-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                          <img class="w-40" src="https://culture.ec.europa.eu/sites/default/files/styles/eac_ratio_16_9_xl/public/2020-08/header-sector-ccs.jpg?h=9ffb04cf&itok=LMbsYP9x" alt="">
                      </th>
                      <td class="px-6 py-4">
                          White
                      </td>
                      <td class="px-6 py-4">
                          Laptop PC
                      </td>
                      <td class="px-6 py-4">
                          $1999
                      </td>
                      <td class="px-6 py-4">
                          99
                      </td>
                      <td class="px-6 py-4 text-right">
                          <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                      </td>
                  </tr>
                   <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                      <th scope="row" class="pl-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                          <img class="w-40" src="https://culture.ec.europa.eu/sites/default/files/styles/eac_ratio_16_9_xl/public/2020-08/header-sector-ccs.jpg?h=9ffb04cf&itok=LMbsYP9x" alt="">
                      </th>
                      <td class="px-6 py-4">
                          White
                      </td>
                      <td class="px-6 py-4">
                          Laptop PC
                      </td>
                      <td class="px-6 py-4">
                          $1999
                      </td>
                      <td class="px-6 py-4">
                          99
                      </td>
                      <td class="px-6 py-4 text-right">
                          <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                      </td>
                  </tr>
              </tbody>
          </table>
      </div>

    </div>
  </article>
</template>
<script>
export default {
  name: 'StudioContent',
  layout:'studio',
  middleware:['auth','checkAuth']
}
</script>
