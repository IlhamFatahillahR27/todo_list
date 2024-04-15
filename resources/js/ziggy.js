const Ziggy = {"url":"http:\/\/localhost","port":null,"defaults":{},"routes":{"ignition.healthCheck":{"uri":"_ignition\/health-check","methods":["GET","HEAD"]},"ignition.executeSolution":{"uri":"_ignition\/execute-solution","methods":["POST"]},"ignition.updateConfig":{"uri":"_ignition\/update-config","methods":["POST"]},"group.show":{"uri":"group\/{group}","methods":["GET","HEAD"],"parameters":["group"],"bindings":{"group":"id"}},"group.update":{"uri":"group\/{group}","methods":["PUT","PATCH"],"parameters":["group"],"bindings":{"group":"id"}},"home":{"uri":"\/","methods":["GET","HEAD"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
