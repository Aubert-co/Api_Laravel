const ne = new Map()


const v = [1,2,3,4,5,6]

v.map((val)=>{
    ne.set(`CheckBoxValue=${val}`,val)
})


const values= ne.values()
const data = [...values]

console.log(data)
