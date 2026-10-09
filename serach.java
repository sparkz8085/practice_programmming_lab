import java.util.*;
public class Serach
{
    public static void main(String [ ] args)
    {
        int i,lb,ub,p,k,ns;
        ns=0;k=0;lb=0;ub=9;p=0;
        int m[ ]=new int[10];
        Scanner in = new Scanner(System.in);
        System.out.println ("Enter the numbers in the array: ");
        for(i=0;i<10;i++)
        {
            m[i]=in.nextInt();
        }
        System.out.println ("Enter the number to be searched:");
        ns= in.nextInt();
        while(lb<=ub)
        {
            p=(lb+ub)/2;
            if(m[p]<ns);
                lb=p+1;
            if(m[p]>ns)
                ub=ub-1;
            if(m[p]==ns)
            {
                k=1;
                break;
            }
        }
        if(k==1)
            System.out.println ("Search Successful");
        else
            System.out.println ("The number is not present");
    }
}
