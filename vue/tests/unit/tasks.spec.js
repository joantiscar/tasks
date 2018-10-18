/* eslint-disable no-unused-expressions,no-undef */
import { expect } from 'chai'
import { mount } from '@vue/test-utils'
import Tasks from '../../../resources/js/components/Tasks.vue'
import moxios from 'moxios'

let exampletasks = [
  {
    id: 1,
    name: 'Comprar pa',
    completed: false
  },
  {
    id: 2,
    name: 'Comprar llet',
    completed: true
  },
  {
    id: 3,
    name: 'Estudiar PHP',
    completed: false
  }
]
describe('Tasks.vue', () => {
  beforeEach(function () {
    moxios.install(global.axios)
  })

  afterEach(function () {
    moxios.uninstall(global.axios)
  })

  it('shows_error_when_api_fails', (done) => {
    // eslint-disable-next-line no-unused-expressions
    moxios.stubRequest('/api/v1/tasks'), {
      status: 500,
      response: {
        data: 'El pantano es de La Sénia, perque el pantano es troba a la pobla, que com tots sabem forma part de l\'imperi senienc'
      }
    }

    done()
  })
  it('shows_error', (done) => {
    // 1 prepare
    moxios.stubRequest('/api/v1/tasks', {
      status: 500,
      response: 'El pantano es de La Sénia, perque el pantano es troba a la pobla, que com tots sabem forma part de lo imperi senienc'
    })
    // 2 Execute

    const wrapper = mount(Tasks)

    // wrapper.vm.errorMessage = 'El pantano es de La Sénia, perque el pantano es troba a la pobla, que com tots sabem forma part de lo imperi senienc'
    // Assertion
    moxios.wait(() => {
      expect(wrapper.text()).contains('El pantano es de La Sénia, perque el pantano es troba a la pobla, que com tots sabem forma part de lo imperi senienc')
      done()
    })
  })

  it('shows_filters_when_is_more_than_0_tasks', () => {
    // 1 prepare

    // 2 Execute

    const wrapper = mount(Tasks, {
      propsData: {
        tasks: [
          {
            id: 1,
            name: 'Comprar pa',
            completed: false
          },
          {
            id: 2,
            name: 'Comprar llet',
            completed: true
          },
          {
            id: 3,
            name: 'Estudiar PHP',
            completed: false
          }
        ]
      }
    })

    wrapper.vm.errorMessage = 'El pantano es de La Sénia, perque el pantano es troba a la pobla, que com tots sabem forma part de lo imperi senienc'
    // Assertion
    expect(wrapper.text()).contains('Filtres')
  })
  it('not_shows_filters_when_is_0_tasks', (done) => {
    // 1 prepare
    moxios.stubRequest('/api/v1/tasks', {
      status: 200,
      response: []
    })
    // 2 Execute

    const wrapper = mount(Tasks)
    // Assertion
    // eslint-disable-next-line no-unused-expressions
    moxios.wait(() => {
      expect(wrapper.text()).not.contains('Filtres')
      done()
    })
  })

  it('contains_a_list_of_tasks', () => {
    // 1 PREPARE (OPTIONAL)

    // 2 EXECUTE
    const wrapper = mount(Tasks, {
      propsData: {
        tasks: exampletasks
      }
    }) // <tasks tasks="[{},{},{}]"></tasks>

    // console.log('AQUI TEXT:')
    // console.log(wrapper.text())
    // console.log('AQUI HTML:')
    // console.log(wrapper.html())
    // 3 EXPECT
    expect(wrapper.text()).contains('Comprar pa')
    expect(wrapper.text()).contains('Comprar llet')
    expect(wrapper.text()).contains('Estudiar PHP')
  })

  it.skip('contains_a_list_of_tasks_from_api_if_no_prop_tasks_is_provided', (done) => {
    // 1 Prepare (opcional)
    moxios.stubRequest('/api/v1/tasks', {
      status: 200,
      response: [
        {
          id: 1,
          name: 'Comprar pa',
          completed: false
        },
        {
          id: 2,
          name: 'Comprar llet',
          completed: true
        },
        {
          id: 3,
          name: 'Estudiar PHP',
          completed: false
        }
      ]
    })

    // 2 Execució
    const wrapper = mount(Tasks) // <tasks></tasks>

    console.log(wrapper.html())
    // 3 expectations
    moxios.wait(() => {
      expect(wrapper.text()).contains('Comprar pa')
      expect(wrapper.text()).contains('Comprar llet')
      expect(wrapper.text()).contains('Estudiar PHP')

      // wrapper.vm -> Objecte Vue (vm: View Model)
      expect(wrapper.vm.dataTasks).to.have.lengthOf(3)
      expect(wrapper.vm.dataTasks[0].id).equals(1)
      expect(wrapper.vm.dataTasks[0].name).equals('Comprar pa')
      expect(wrapper.vm.dataTasks[0].completed).equals(false)

      expect(wrapper.vm.dataTasks[1].id).equals(2)
      expect(wrapper.vm.dataTasks[1].name).equals('Comprar llet')
      expect(wrapper.vm.dataTasks[1].completed).equals(true)

      expect(wrapper.vm.dataTasks[2].id).equals(3)
      expect(wrapper.vm.dataTasks[2].name).equals('Estudiar PHP')
      expect(wrapper.vm.dataTasks[2].completed).equals(false)
      expect(wrapper.find('span#dataTask2').classes('strike')).to.be.true

      done()
    })
  })
})

it.only('delete_a_task', (done) => {
  moxios.stubRequest('/api/v1/tasks/1', {
    name: 'Comprar lejia2',
    completed: false
  })

  const wrapper = mount(Tasks, {
    propsData: {
      tasks: exampletasks
    }
  })
    let deleteIcon = wrapper.find('span#delete_task_1')
  deleteIcon.trigger('click')

  moxios.wait(() => {
    expect(wrapper.text()).not.contains('Comprar pa')
    done()
  })
})

it.skip('adds_a_task', (done) => {
  // 1
  moxios.stubRequest('/api/v1/tasks', {
    name: 'Comprar lejia2',
    completed: false
  })
  // 2
  const wrapper = mount(Tasks, {
    propsData: {
      tasks: exampletasks
    }
  })
  // input name tasks
  let inputName = wrapper.find("input[name='name']")
  inputName.element.value = 'Comprar lejia2'
  inputName.trigger('input')
  let button = wrapper.find('button#button_add_task')
  button.trigger('click')

  // 3
  moxios.wait(() => {
    expect(wrapper.text()).contains('Comprar lejia2')
    done()
  }
  )
})
