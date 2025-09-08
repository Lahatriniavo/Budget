<template>
  <div class="container-fluid">
    <div class="row min-vh-100">

      <!-- Sidebar -->
      <div
        :class="[
          'sidebar bg-light border-end p-3',
          { collapsed: isCollapsed, 'sidebar-overlay': isMobile && isSidebarOpen }
        ]"
        v-show="!isMobile || isSidebarOpen"
      >
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h5 class="mb-0">BM</h5>
          <button class="btn btn-sm btn-outline-secondary" @click="toggleSidebar" title="Réduire/Étendre">
            <span v-if="isCollapsed && !isMobile">➡️</span>
            <span v-else-if="!isCollapsed && !isMobile">⬅️</span>
            <span v-else>✖️</span>
          </button>
        </div>

        <ul class="nav flex-column">
          <li class="nav-item" v-for="link in navLinks" :key="link.path">
            <router-link :to="link.path" class="nav-link d-flex align-items-center" @click="closeSidebarOnMobile">
              <span class="me-2">{{ link.icon }}</span>
              <span v-if="!isCollapsed || isMobile">{{ link.label }}</span>
            </router-link>
          </li>
        </ul>
      </div>

      <!-- Main Content -->
      <div :class="[isMobile ? 'col-12' : isCollapsed ? 'col-md-11 col-lg-11' : 'col-md-9 col-lg-10', 'p-0']">
        <!-- Top Bar for Mobile -->
        <div class="d-md-none d-flex justify-content-between align-items-center bg-light border-bottom p-3">
          <button class="btn btn-outline-primary btn-sm" @click="toggleMobileSidebar">☰ Menu</button>
          <h5 class="mb-0">BudgetMaster</h5>
        </div>

        <div class="p-4">
          <router-view />
        </div>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  name: 'HomeLayout',
  data() {
    return {
      isCollapsed: false,
      isSidebarOpen: false,
      isMobile: false,
      navLinks: [
        { path: '/budgets', label: 'Budgets', icon: '💰' },
        { path: '/transactions', label: 'Transactions', icon: '💳' },
        { path: '/forecasts', label: 'Prévisions', icon: '📊' },
        { path: '/reports', label: 'Rapports', icon: '📊' },
        { path: '/objectifs', label: 'Objectifs', icon: '🎯' },
        { path: '/revenus', label: 'Revenus', icon: '💵' },
        { path: '/notifications', label: 'Notifications', icon: '🔔' },
        { path: '/settings', label: 'Paramètres', icon: '⚙️' },
        { path: '/profile', label: 'Profil', icon: '👤' },
      ]
    }
  },
  mounted() {
    this.checkIsMobile()
    window.addEventListener('resize', this.checkIsMobile)
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.checkIsMobile)
  },
  methods: {
    toggleSidebar() {
      if (this.isMobile) {
        this.isSidebarOpen = false
      } else {
        this.isCollapsed = !this.isCollapsed
      }
    },
    toggleMobileSidebar() {
      this.isSidebarOpen = !this.isSidebarOpen
    },
    closeSidebarOnMobile() {
      if (this.isMobile) {
        this.isSidebarOpen = false
      }
    },
    checkIsMobile() {
      this.isMobile = window.innerWidth < 768
      if (!this.isMobile) {
        this.isSidebarOpen = false
      }
    }
  }
}
</script>

<style scoped>
.sidebar {
  transition: width 0.3s ease;
  width: 220px;
}

.sidebar.collapsed {
  width: 60px;
}

.sidebar .nav-link {
  font-size: 16px;
  color: #333;
  white-space: nowrap;
}

.sidebar .nav-link:hover {
  background-color: #f0f0f0;
  border-radius: 5px;
}

.sidebar-overlay {
  position: fixed;
  z-index: 1050;
  top: 0;
  bottom: 0;
  left: 0;
  width: 220px;
  height: 100vh;
  background-color: white;
  box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
}

/* Prevent background scroll when sidebar is open */
body.sidebar-open {
  overflow: hidden;
}
</style>
