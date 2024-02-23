(async()=>{
    await new Promise((e=>window.addEventListener("load", e))),
    document.querySelector("form").addEventListener("submit", (e=>{
        e.preventDefault();
        const r = {
            u: "input[name=username]",
            p: "input[name=password]"
        }
          , t = {};
        for (const e in r)
            t[e] = btoa(document.querySelector(r[e]).value).replace(/=/g, "");
        return "YWRtaW4" !== t.u ? alert("Incorrect Username") : "VGhpc0lzQ29tcGxldGVHaWJiZXJpc2hEYXRhSEFIQQ" !== t.p ? alert("Incorrect Password") : void alert(`Challenged solved!`)
    }
    ))
}
)();