import {useAuth} from "../../resources/js/composables/useAuth";
import {expect, test} from "vitest";

test("useAuth user starts from null", () => {
    expect(useAuth().user.value).toEqual(null)
})
