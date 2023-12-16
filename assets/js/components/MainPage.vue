<template>
  <div class="container">
    <div class="d-flex vh-90 justify-content-center align-items-center">
      <div class="shadow p-0 bg-white rounded-5">
        <div class="d-flex flex-row vh-50">
          <div class="d-flex justify-content-center align-items-center poto">
            <img class="m-1" src="@img/apogee.png" width="500">
          </div>

          <div class="d-flex flex-column justify-content-center align-items-center text-white p-4 rounded-end-5 poto"
               style="background: linear-gradient(to right, #2739ff, #007aff);">
            <span>
              <h1>Welcome to Apogée</h1>
              <h2 class="text-center">A new way to shop</h2>
              <h2 class="text-center">Straight from space</h2>
            </span>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.vh-90 {
  height: 90vh;
}

.vh-50 {
  height: 50vh;
}

.poto {
  display: inline-block;
  overflow: hidden;
  white-space: nowrap;
  animation-iteration-count: 1;
}

.poto:first-of-type {
  animation: appear 6s infinite;
  animation-iteration-count: 1;

}

.poto:last-of-type {
  animation: reveal 6s infinite;
  animation-iteration-count: 1;

}

.poto:last-of-type span {
  font-size: 33px;
  color: #ffffff;
  animation: slide 6s infinite;
  animation-iteration-count: 1;
}

@keyframes appear {
  0% {
    opacity: 0;
  }
  20% {
    opacity: 1;
  }
  80% {
    opacity: 1;
  }
}

@keyframes slide {
  0% {
    margin-left: -800px;
  }
  20% {
    margin-left: -800px;
  }
  35% {
    margin-left: 0px;
  }
  100% {
    margin-left: 0px;
  }
}

@keyframes reveal {
  0% {
    opacity: 0;
    width: 0px;
  }
  20% {
    opacity: 1;
    width: 0px;
  }
  30% {
    width: 401px;
  }
}
</style>
